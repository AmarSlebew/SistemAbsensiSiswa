<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user.name')
                    ->label('Nama Guru')
                    ->required(),

                TextInput::make('user.email')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->hiddenOn(['edit'])
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                TextInput::make('nip')
                    ->required(),
                Select::make('subjects')
                    ->relationship(
                        'subjects',
                        'name'
                    )
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->label('Mata Pelajaran')
            ]);
    }
}
