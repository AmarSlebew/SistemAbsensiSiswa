<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RecapController extends Controller
{
    private function getTeacher()
    {
        return Auth::user()->teacher;
    }

    public function index(Request $request)
    {
        $teacher = $this->getTeacher();

        // 1. Ambil daftar kelas yang pernah diajar guru ini untuk filter dropdown
        $classrooms = Classroom::whereHas('attendances', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->orderBy('name')->get();

        // Jika guru belum pernah absen, tapi ingin melihat kelas,
        // kita bisa fallback ke semua kelas agar halaman tidak kosong total
        if ($classrooms->isEmpty()) {
            $classrooms = Classroom::orderBy('name')->get();
        }

        // 2. Ambil daftar mapel yang diajar guru ini untuk filter dropdown
        $subjects = $teacher->subjects->isNotEmpty()
            ? $teacher->subjects()->orderBy('name')->get()
            : Subject::orderBy('name')->get();

        $selectedClassroom = $request->input('classroom_id');
        $selectedSubject   = $request->input('subject_id');
        $startDate         = $request->input('start_date');
        $endDate           = $request->input('end_date');

        $recapData = $this->computeRecap($selectedClassroom, $selectedSubject, $startDate, $endDate);

        return view('guru.rekap.index', compact(
            'classrooms',
            'subjects',
            'recapData',
            'selectedClassroom',
            'selectedSubject',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Helper to compute attendance recap data for a classroom with filters.
     */
    private function computeRecap($selectedClassroom, $selectedSubject = null, $startDate = null, $endDate = null)
    {
        $teacher = $this->getTeacher();
        $recapData = collect();

        if (!$selectedClassroom) {
            return $recapData;
        }

        $students = Student::where('classroom_id', $selectedClassroom)
            ->orderBy('name')
            ->get();

        // Bangun query dasar pencarian absensi
        $attendanceQuery = Attendance::where('classroom_id', $selectedClassroom)
            ->where('teacher_id', $teacher->id);

        if ($selectedSubject) {
            $attendanceQuery->where('subject_id', $selectedSubject);
        }

        if ($startDate) {
            $attendanceQuery->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $attendanceQuery->where('date', '<=', $endDate);
        }

        // Dapatkan semua ID absensi yang memenuhi kriteria filter
        $attendanceIds = $attendanceQuery->pluck('id');

        // Hitung statistik per siswa
        foreach ($students as $student) {
            $stats = DB::table('attendance_details')
                ->select('status', DB::raw('count(*) as count'))
                ->whereIn('attendance_id', $attendanceIds)
                ->where('student_id', $student->id)
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            $hadir = $stats['Hadir'] ?? 0;
            $izin  = $stats['Izin'] ?? 0;
            $sakit = $stats['Sakit'] ?? 0;
            $alpa  = $stats['Alpa'] ?? 0;
            $total = $hadir + $izin + $sakit + $alpa;

            $percentage = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

            $recapData->push((object)[
                'student'    => $student,
                'hadir'      => $hadir,
                'izin'       => $izin,
                'sakit'      => $sakit,
                'alpa'       => $alpa,
                'total'      => $total,
                'percentage' => $percentage
            ]);
        }

        return $recapData;
    }

    /**
     * Ekspor rekap absensi kelas ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $teacher = $this->getTeacher()->load('user');
        $selectedClassroom = $request->input('classroom_id');
        
        abort_if(!$selectedClassroom, 400, 'Kelas harus dipilih.');

        $classroom = Classroom::findOrFail($selectedClassroom);
        
        $selectedSubject = $request->input('subject_id');
        $subject = $selectedSubject ? Subject::find($selectedSubject) : null;
        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $recapData = $this->computeRecap($selectedClassroom, $selectedSubject, $startDate, $endDate);

        $pdf = Pdf::loadView('guru.rekap.pdf', compact(
            'classroom',
            'subject',
            'recapData',
            'startDate',
            'endDate',
            'teacher'
        ));

        $filename = 'Rekap_Absensi_' . str_replace(' ', '_', $classroom->name) . '.pdf';
        return $pdf->download($filename);
    }
}
