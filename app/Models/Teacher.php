<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id','nip'])]
class Teacher extends Model
{
    //
    public function user() {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::deleting(function ($teacher) {
            $teacher->user()->delete();
        });
    }

    public function subjects() {
        return $this->belongsToMany(
            Subject::class,
            'subject_teacher',
            );
    }

    public function attendanceDetails()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}
