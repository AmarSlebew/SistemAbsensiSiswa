<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $user = User::create([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'password' => $data['password'],
            'role' => 'guru',
            'is_approved' => true,
        ]);

        return Teacher::create([
            'user_id' => $user->id,
            'nip' => $data['nip'],
        ]);
    }
}
