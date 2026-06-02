<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['classroom_id', 'teacher_id', 'subject_id', 'date'])]
class Attendance extends Model
{
    //
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function details()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}
