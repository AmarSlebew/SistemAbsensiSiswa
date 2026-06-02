<?php

namespace App\Filament\Resources\Attendances\Schemas;

use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('classroom_id')
                    ->label('Kelas')
                    ->options(
                        Classroom::all()
                            ->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable(),
                Select::make('teacher_id')
                    ->label('Guru')
                    ->options(
                        Teacher::with('user')
                            ->get()
                            ->pluck('user.name', 'id')
                    )
                    ->required()
                    ->searchable(),
                Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->options(
                        Subject::all()
                            ->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable(),
                DatePicker::make('date')
                    ->required(),
            ]);
    }
}
