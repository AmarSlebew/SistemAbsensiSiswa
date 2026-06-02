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

        $recapData = collect();

        // 3. Jika kelas dipilih, hitung rekap per siswa
        if ($selectedClassroom) {
            $students = Student::where('classroom_id', $selectedClassroom)
                ->orderBy('name')
                ->get();

            // Bangun query dasar pencarian absensi
            $attendanceQuery = Attendance::where('classroom_id', $selectedClassroom);

            // Filter guru yang mengajar
            $attendanceQuery->where('teacher_id', $teacher->id);

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
                // Query detil absensi untuk siswa ini dalam sesi absensi yang difilter
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
        }

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
}
