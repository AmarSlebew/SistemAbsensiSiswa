<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    collect([
        'Matematika',
        'Bahasa Indonesia',
        'Bahasa Inggris',
        'Informatika',
        'Fisika',
        'Kimia',
        'Biologi',
        'Sejarah',
        'Geografi',
        'Ekonomi',
        'Pendidikan Pancasila',
        'Sosiologi',
        'Seni Budaya',
        'Pendidikan Jasmani',
        'Pendidikan Agama',
    ])->each(fn ($Subject) =>
        Subject::create(['name' => $Subject])
    );
}
}
