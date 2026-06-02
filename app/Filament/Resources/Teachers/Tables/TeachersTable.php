<?php

namespace App\Filament\Resources\Teachers\Tables;


use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
    ->columns([
        TextColumn::make('user.name')
            ->label('Nama Guru'),

        TextColumn::make('nip'),

        IconColumn::make('user.is_approved')
            ->label('Status')
            ->boolean(),
        TextColumn::make('user.email')
            ->label('Email'),
        TextColumn::make('subjects.name')
            ->badge()
            ->label('Mata Pelajaran')
    ])

    ->recordActions([
        EditAction::make(),
        DeleteAction::make(),

        Action::make('approve')
            ->label('Approve')
            ->icon('heroicon-o-check')
            ->color('success')
            ->visible(fn ($record) => ! $record->user->is_approved)
            ->action(fn ($record) => $record->user->update([
                'is_approved' => true,
            ])),
        ]);
    }
}
