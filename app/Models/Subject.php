<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class Subject extends Model
{
    //

    public function teachers() {
        return $this->belongsToMany(
            Teacher::class,
            'subject_teacher'
        );
    }

    public function attendanceDetails()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}
