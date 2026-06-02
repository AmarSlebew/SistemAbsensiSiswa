<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@school.com',
                'nip' => '198501010001',
                'subjects' => [1], // Matematika
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@school.com',
                'nip' => '198501010002',
                'subjects' => [2], // Bahasa Indonesia
            ],
            [
                'name' => 'Citra Lestari',
                'email' => 'citra@school.com',
                'nip' => '198501010003',
                'subjects' => [3], // Bahasa Inggris
            ],
            [
                'name' => 'Dewi Anggraini',
                'email' => 'dewi@school.com',
                'nip' => '198501010004',
                'subjects' => [4], // Informatika
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko@school.com',
                'nip' => '198501010005',
                'subjects' => [5], // Fisika
            ],
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri@school.com',
                'nip' => '198501010006',
                'subjects' => [6], // Kimia
            ],
            [
                'name' => 'Gilang Ramadhan',
                'email' => 'gilang@school.com',
                'nip' => '198501010007',
                'subjects' => [7], // Biologi
            ],
            [
                'name' => 'Hendra Saputra',
                'email' => 'hendra@school.com',
                'nip' => '198501010008',
                'subjects' => [8], // Sejarah
            ],
            [
                'name' => 'Indah Permata',
                'email' => 'indah@school.com',
                'nip' => '198501010009',
                'subjects' => [9], // Geografi
            ],
            [
                'name' => 'Joko Susilo',
                'email' => 'joko@school.com',
                'nip' => '198501010010',
                'subjects' => [10], // Ekonomi
            ],
            [
                'name' => 'Kartika Sari',
                'email' => 'kartika@school.com',
                'nip' => '198501010011',
                'subjects' => [1, 4], // Matematika + Informatika
            ],
            [
                'name' => 'Lukman Hakim',
                'email' => 'lukman@school.com',
                'nip' => '198501010012',
                'subjects' => [5, 6], // Fisika + Kimia
            ],
            [
                'name' => 'Maya Putri',
                'email' => 'maya@school.com',
                'nip' => '198501010013',
                'subjects' => [2, 8], // Bahasa Indonesia + Sejarah
            ],
            [
                'name' => 'Nanda Wijaya',
                'email' => 'nanda@school.com',
                'nip' => '198501010014',
                'subjects' => [3, 4], // Inggris + Informatika
            ],
            [
                'name' => 'Rina Amelia',
                'email' => 'rina@school.com',
                'nip' => '198501010015',
                'subjects' => [7, 9], // Biologi + Geografi
            ],
        ];

        foreach ($teachers as $teacherData) {

            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('password'),
                'role' => 'guru',
                'is_approved' => true,
            ]);

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'nip' => $teacherData['nip'],
            ]);

            $teacher->subjects()->attach(
                $teacherData['subjects']
            );
        }
    }
}
