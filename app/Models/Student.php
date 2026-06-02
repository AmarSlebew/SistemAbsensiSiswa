<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'nis', 'gender', 'birth_date', 'classroom_id'])]
class Student extends Model
{
    //
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function attendanceDetails()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}
