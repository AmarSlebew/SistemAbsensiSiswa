<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = [
            'Ahmad', 'Andi', 'Budi', 'Citra', 'Dewi',
            'Eko', 'Farhan', 'Gilang', 'Hendra', 'Indah',
            'Joko', 'Kartika', 'Lukman', 'Maya', 'Nanda',
            'Putri', 'Rina', 'Siti', 'Taufik', 'Wahyu'
        ];

        $lastNames = [
            'Saputra', 'Pratama', 'Wijaya', 'Nugroho',
            'Permata', 'Lestari', 'Ramadhan', 'Putra',
            'Handayani', 'Susanto'
        ];

        $classrooms = Classroom::all();

        for ($i = 1; $i <= 100; $i++) {

            $name =
                $firstNames[array_rand($firstNames)]
                . ' ' .
                $lastNames[array_rand($lastNames)];

            Student::create([
                'nis' => '2026' . str_pad($i, 4, '0', STR_PAD_LEFT),

                'name' => $name,

                'gender' => rand(0, 1)
                    ? 'L'
                    : 'P',

                'birth_date' => now()
                    ->subYears(rand(15, 18))
                    ->subDays(rand(1, 365)),

                'classroom_id' => $classrooms
                    ->random()
                    ->id,
            ]);
        }
    }
}
