<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Disiplinku',
            'email' => 'admin@gmail.com',
            'role' => 'Admin',
            'password' => '112233',
        ]);

    $this->call([
        ClassSeeder::class,
        SubjectSeeder::class,
        TeacherSeeder::class,
        StudentSeeder::class,
        AttendanceSeeder::class,
    ]);
    }
}
