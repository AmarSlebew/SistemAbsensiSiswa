<?php

use App\Models\User;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // 1. Create a User with role 'guru'
    $this->user = User::create([
        'name' => 'Guru Test',
        'email' => 'gurutest@school.com',
        'password' => bcrypt('password'),
        'role' => 'guru',
        'is_approved' => true,
    ]);

    // 2. Create Teacher
    $this->teacher = Teacher::create([
        'user_id' => $this->user->id,
        'nip' => '1234567890',
    ]);

    // 3. Create Classroom
    $this->classroom = Classroom::create([
        'name' => 'XI-A',
    ]);

    // 4. Create Subject
    $this->subject = Subject::create([
        'name' => 'Matematika',
    ]);

    // Associate teacher with subject
    $this->teacher->subjects()->attach($this->subject->id);

    // 5. Create Student
    $this->student = Student::create([
        'classroom_id' => $this->classroom->id,
        'name' => 'Siswa Test',
        'nis' => '10001',
        'gender' => 'L',
    ]);

    // 6. Create Attendance Session
    $this->attendance = Attendance::create([
        'classroom_id' => $this->classroom->id,
        'teacher_id' => $this->teacher->id,
        'subject_id' => $this->subject->id,
        'date' => '2026-06-03',
    ]);

    // 7. Create Attendance Detail
    $this->detail = AttendanceDetail::create([
        'attendance_id' => $this->attendance->id,
        'student_id' => $this->student->id,
        'status' => 'Hadir',
    ]);
});

it('can export individual attendance session to PDF', function () {
    $response = $this->actingAs($this->user)
        ->get(route('absensi.pdf', $this->attendance->id));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
    $response->assertHeader('content-disposition', 'attachment; filename="Absensi_XI-A_2026-06-03.pdf"');
});

it('can export cumulative classroom attendance recap to PDF', function () {
    $response = $this->actingAs($this->user)
        ->get(route('rekap.pdf', [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
    $response->assertHeader('content-disposition', 'attachment; filename="Rekap_Absensi_XI-A.pdf"');
});
