<?php

namespace App\Filament\Resources\Classrooms\Schemas;

use App\Models\Teacher;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClassroomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
    ->components([
        TextInput::make('name')
            ->label('Nama Kelas')
            ->required(),

        Select::make('homeroom_teacher_id')
            ->label('Wali Kelas')
            ->options(
                Teacher::with('user')
                    ->get()
                    ->pluck('user.name', 'id')
            )
            ->searchable(),
        ]);
    }
}
