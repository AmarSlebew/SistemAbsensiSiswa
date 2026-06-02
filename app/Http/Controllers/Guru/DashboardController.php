<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $teacher = $user->teacher;

        // Jika belum ada profil teacher, tampilkan dashboard kosong
        if (! $teacher) {
            return view('dashboard', [
                'teacher'              => null,
                'classrooms'           => collect(),
                'totalStudents'        => 0,
                'todaySessions'        => 0,
                'todayAlpha'           => 0,
                'attendancePercentage' => 0,
                'totalMonth'           => 0,
                'chartLabels'          => [],
                'chartData'            => [],
                'recentAttendances'    => collect(),
                'hasData'              => false,
            ]);
        }

        // Kelas yang pernah diajar guru ini (berdasarkan tabel attendances)
        $taughtClassroomIds = Attendance::where('teacher_id', $teacher->id)
            ->distinct()
            ->pluck('classroom_id');

        $classrooms    = Classroom::whereIn('id', $taughtClassroomIds)->get();
        $totalStudents = Student::whereIn('classroom_id', $taughtClassroomIds)->count();

        // Sesi absensi hari ini
        $todaySessions = Attendance::where('teacher_id', $teacher->id)
            ->whereDate('date', today())
            ->count();

        // Jumlah siswa Alpa hari ini
        $todayAlpha = AttendanceDetail::whereHas('attendance', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id)
              ->whereDate('date', today());
        })->where('status', 'Alpa')->count();

        // Persentase kehadiran bulan ini
        $totalMonth = AttendanceDetail::whereHas('attendance', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id)
              ->whereMonth('date', now()->month)
              ->whereYear('date', now()->year);
        })->count();

        $hadirMonth = AttendanceDetail::whereHas('attendance', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id)
              ->whereMonth('date', now()->month)
              ->whereYear('date', now()->year);
        })->where('status', 'Hadir')->count();

        $attendancePercentage = $totalMonth > 0
            ? round(($hadirMonth / $totalMonth) * 100, 1)
            : 0;

        // Data chart: jumlah siswa Hadir per hari selama 7 hari terakhir
        $chartLabels = [];
        $chartData   = [];
        $dayNames    = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        for ($i = 6; $i >= 0; $i--) {
            $date          = now()->subDays($i);
            $chartLabels[] = $dayNames[$date->dayOfWeek] . ', ' . $date->format('d/m');
            $chartData[]   = AttendanceDetail::whereHas('attendance', function ($q) use ($teacher, $date) {
                $q->where('teacher_id', $teacher->id)
                  ->whereDate('date', $date->toDateString());
            })->where('status', 'Hadir')->count();
        }

        // 5 sesi absensi terakhir yang diinput guru ini
        $recentAttendances = Attendance::with(['classroom', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->latest('date')
            ->take(5)
            ->get()
            ->map(function ($att) {
                $total        = $att->details()->count();
                $hadir        = $att->details()->where('status', 'Hadir')->count();
                $alpa         = $att->details()->where('status', 'Alpa')->count();
                $att->total   = $total;
                $att->hadir   = $hadir;
                $att->alpa    = $alpa;
                $att->persen  = $total > 0 ? round(($hadir / $total) * 100) : 0;
                return $att;
            });

        $hasData = $taughtClassroomIds->isNotEmpty();

        return view('dashboard', compact(
            'teacher',
            'classrooms',
            'totalStudents',
            'todaySessions',
            'todayAlpha',
            'attendancePercentage',
            'totalMonth',
            'chartLabels',
            'chartData',
            'recentAttendances',
            'hasData'
        ));
    }
}
