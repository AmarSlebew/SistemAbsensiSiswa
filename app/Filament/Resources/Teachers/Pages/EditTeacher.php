<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user'] = [
            'name' => $this->record->user->name,
            'email' => $this->record->user->email,
        ];

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->user->update([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
        ]);

        $record->update([
            'nip' => $data['nip'],
        ]);

        return $record;
    }
}
