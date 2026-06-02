<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada data guru, kelas, dan siswa
        $teachers = Teacher::all();
        $classrooms = Classroom::with('students')->get();
        $subjects = Subject::all();

        if ($teachers->isEmpty() || $classrooms->isEmpty() || $subjects->isEmpty()) {
            $this->command->warn('Pastikan database sudah memiliki data Teacher, Classroom, dan Student terlebih dahulu!');
            return;
        }

        // Tentukan rentang tanggal absensi (30 hari ke belakang)
        $dates = [];
        $startDate = Carbon::now()->subDays(30);
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);
            // Hanya buat absensi di hari kerja (Senin - Jumat)
            if (!$date->isWeekend()) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        $this->command->info('Memulai seeding data absensi dummy untuk ' . count($dates) . ' hari...');


        $studentBehavior = [];

        foreach ($classrooms as $classroom) {
            $students = $classroom->students;
            if ($students->isEmpty()) continue;

            $shuffled = $students->shuffle();
            $total = $shuffled->count();

            // Bagi proporsi kategori: 75% Disiplin, 15% Cukup Disiplin, 10% Tidak Disiplin
            $disciplinedCount = max(1, (int)($total * 0.75));
            $neutralCount = max(1, (int)($total * 0.15));

            foreach ($shuffled as $index => $student) {
                if ($index < $disciplinedCount) {
                    $studentBehavior[$student->id] = 'Sangat Disiplin';
                } elseif ($index < ($disciplinedCount + $neutralCount)) {
                    $studentBehavior[$student->id] = 'Cukup Disiplin';
                } else {
                    $studentBehavior[$student->id] = 'Tidak Disiplin';
                }
            }
        }

        // Loop untuk setiap hari kerja
        foreach ($dates as $dateStr) {
            foreach ($classrooms as $classroom) {
                $students = $classroom->students;
                if ($students->isEmpty()) continue;

                // Pilih guru dan mapel secara acak
                $teacher = $teachers->random();
                $subject = $subjects->random();


                $attendance = Attendance::create([
                    'classroom_id' => $classroom->id,
                    'teacher_id'   => $teacher->id,
                    'subject_id'   => $subject->id,
                    'date'         => $dateStr,
                ]);

                // 2. Buat Detail Absensi untuk masing-masing siswa berdasarkan perilakunya
                foreach ($students as $student) {
                    $behavior = $studentBehavior[$student->id] ?? 'Sangat Disiplin';

                    $status = 'Hadir'; // Default

                    if ($behavior === 'Sangat Disiplin') {
                        // 96% Hadir, 2% Izin, 2% Sakit, 0% Alpa
                        $rand = rand(1, 100);
                        if ($rand <= 96) {
                            $status = 'Hadir';
                        } elseif ($rand <= 98) {
                            $status = 'Izin';
                        } else {
                            $status = 'Sakit';
                        }
                    } elseif ($behavior === 'Cukup Disiplin') {
                        // 80% Hadir, 10% Izin/Sakit, 10% Alpa
                        $rand = rand(1, 100);
                        if ($rand <= 80) {
                            $status = 'Hadir';
                        } elseif ($rand <= 90) {
                            $status = rand(0, 1) ? 'Izin' : 'Sakit';
                        } else {
                            $status = 'Alpa';
                        }
                    } else {
                        // Tidak Disiplin: 55% Hadir, 10% Izin/Sakit, 35% Alpa
                        $rand = rand(1, 100);
                        if ($rand <= 55) {
                            $status = 'Hadir';
                        } elseif ($rand <= 65) {
                            $status = rand(0, 1) ? 'Izin' : 'Sakit';
                        } else {
                            $status = 'Alpa';
                        }
                    }

                    AttendanceDetail::create([
                        'attendance_id' => $attendance->id,
                        'student_id'    => $student->id,
                        'status'        => $status,
                    ]);
                }
            }
        }

        $this->command->info('Seeding data absensi dummy berhasil diselesaikan!');
    }
}
