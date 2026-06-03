<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    private function getTeacher()
    {
        return Auth::user()->teacher;
    }

    /**
     * Daftar sesi absensi yang pernah diinput guru ini.
     */
    public function index()
    {
        $teacher = $this->getTeacher();

        $attendances = Attendance::with(['classroom', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->latest('date')
            ->paginate(15);

        // Hitung ringkasan per sesi
        $attendances->getCollection()->transform(function ($att) {
            $att->total_students = $att->details()->count();
            $att->hadir_count    = $att->details()->where('status', 'Hadir')->count();
            $att->alpa_count     = $att->details()->where('status', 'Alpa')->count();
            return $att;
        });

        return view('guru.absensi.index', compact('attendances'));
    }

    /**
     * Form input absensi baru.
     */
    public function create()
    {
        $teacher    = $this->getTeacher();
        $classrooms = Classroom::has('students')->orderBy('name')->get();

        // Tampilkan mata pelajaran guru; jika kosong tampilkan semua
        $subjects = $teacher->subjects->isNotEmpty()
            ? $teacher->subjects()->orderBy('name')->get()
            : Subject::orderBy('name')->get();

        return view('guru.absensi.create', compact('classrooms', 'subjects'));
    }

    /**
     * AJAX — ambil daftar siswa + status absensi yang sudah ada (jika ada).
     */
    public function getStudents(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id'   => 'required|exists:subjects,id',
            'date'         => 'required|date',
        ]);

        $teacher  = $this->getTeacher();
        $students = Student::where('classroom_id', $request->classroom_id)
            ->orderBy('name')
            ->get(['id', 'name', 'nis', 'gender']);

        // Cek apakah sesi sudah ada
        $existing = Attendance::where([
            'teacher_id'   => $teacher->id,
            'classroom_id' => $request->classroom_id,
            'subject_id'   => $request->subject_id,
            'date'         => $request->date,
        ])->with('details')->first();

        $existingDetails = [];
        if ($existing) {
            foreach ($existing->details as $detail) {
                $existingDetails[$detail->student_id] = $detail->status;
            }
        }

        return response()->json([
            'students'        => $students,
            'existing_id'     => $existing?->id,
            'existing_details' => $existingDetails,
        ]);
    }

    /**
     * Simpan sesi absensi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id'    => 'required|exists:classrooms,id',
            'subject_id'      => 'required|exists:subjects,id',
            'date'            => 'required|date',
            'statuses'        => 'required|array|min:1',
            'statuses.*'      => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        $teacher = $this->getTeacher();

        // Cek duplikat
        $exists = Attendance::where([
            'teacher_id'   => $teacher->id,
            'classroom_id' => $request->classroom_id,
            'subject_id'   => $request->subject_id,
            'date'         => $request->date,
        ])->first();

        if ($exists) {
            return redirect()->route('absensi.edit', $exists->id)
                ->with('warning', 'Absensi untuk sesi ini sudah ada. Silakan edit.');
        }

        DB::transaction(function () use ($request, $teacher) {
            $attendance = Attendance::create([
                'teacher_id'   => $teacher->id,
                'classroom_id' => $request->classroom_id,
                'subject_id'   => $request->subject_id,
                'date'         => $request->date,
            ]);

            foreach ($request->statuses as $studentId => $status) {
                AttendanceDetail::create([
                    'attendance_id' => $attendance->id,
                    'student_id'    => $studentId,
                    'status'        => $status,
                ]);
            }
        });

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil disimpan.');
    }

    /**
     * Detail satu sesi absensi.
     */
    public function show(Attendance $attendance)
    {
        $teacher = $this->getTeacher();

        // Pastikan hanya guru yang membuat bisa lihat
        abort_if($attendance->teacher_id !== $teacher->id, 403);

        $attendance->load(['classroom', 'subject', 'details.student']);

        $summary = [
            'hadir' => $attendance->details->where('status', 'Hadir')->count(),
            'izin'  => $attendance->details->where('status', 'Izin')->count(),
            'sakit' => $attendance->details->where('status', 'Sakit')->count(),
            'alpa'  => $attendance->details->where('status', 'Alpa')->count(),
            'total' => $attendance->details->count(),
        ];

        return view('guru.absensi.show', compact('attendance', 'summary'));
    }

    /**
     * Form edit absensi yang sudah ada.
     */
    public function edit(Attendance $attendance)
    {
        $teacher = $this->getTeacher();
        abort_if($attendance->teacher_id !== $teacher->id, 403);

        $attendance->load(['classroom', 'subject', 'details.student']);

        $existingDetails = $attendance->details->pluck('status', 'student_id');

        return view('guru.absensi.edit', compact('attendance', 'existingDetails'));
    }

    /**
     * Update absensi yang sudah ada.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $teacher = $this->getTeacher();
        abort_if($attendance->teacher_id !== $teacher->id, 403);

        $request->validate([
            'statuses'   => 'required|array|min:1',
            'statuses.*' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        DB::transaction(function () use ($request, $attendance) {
            foreach ($request->statuses as $studentId => $status) {
                AttendanceDetail::updateOrCreate(
                    ['attendance_id' => $attendance->id, 'student_id' => $studentId],
                    ['status' => $status]
                );
            }
        });

        return redirect()->route('absensi.show', $attendance->id)
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    /**
     * Ekspor detail sesi absensi ke PDF.
     */
    public function exportPdf(Attendance $attendance)
    {
        $teacher = $this->getTeacher();
        abort_if($attendance->teacher_id !== $teacher->id, 403);

        $attendance->load(['classroom', 'subject', 'details.student', 'teacher.user']);

        $summary = [
            'hadir' => $attendance->details->where('status', 'Hadir')->count(),
            'izin'  => $attendance->details->where('status', 'Izin')->count(),
            'sakit' => $attendance->details->where('status', 'Sakit')->count(),
            'alpa'  => $attendance->details->where('status', 'Alpa')->count(),
            'total' => $attendance->details->count(),
        ];

        $pdf = Pdf::loadView('guru.absensi.pdf', compact('attendance', 'summary'));
        
        $filename = 'Absensi_' . str_replace(' ', '_', $attendance->classroom->name) . '_' . $attendance->date . '.pdf';
        return $pdf->download($filename);
    }
}
