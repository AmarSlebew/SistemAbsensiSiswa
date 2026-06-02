<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            'X IPA 1',
            'X IPA 2',
            'X IPA 3',
            'X IPS 1',
            'X IPS 2',

            'XI IPA 1',
            'XI IPA 2',
            'XI IPA 3',
            'XI IPS 1',
            'XI IPS 2',

            'XII IPA 1',
            'XII IPA 2',
            'XII IPA 3',
            'XII IPS 1',
            'XII IPS 2',
        ];

        $teachers = Teacher::all();

        foreach ($classes as $index => $class) {

            Classroom::create([
                'name' => $class,
                'homeroom_teacher_id' => $teachers[$index]->id ?? null,
            ]);
        }
    }
}
