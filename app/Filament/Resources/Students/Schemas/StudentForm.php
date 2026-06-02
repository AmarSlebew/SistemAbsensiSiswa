<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('nis')
                    ->required()
                    ->unique(),
                Select::make('gender')
                    ->options(['L' => 'L', 'P' => 'P'])
                    ->required(),
                DatePicker::make('birth_date')
                    ->required(),
                Select::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->required()
                    ->searchable(),
            ]);
    }
}
