<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'homeroom_teacher_id'])]
class Classroom extends Model
{
    //
        public function homeroomTeacher()
        {
            return $this->belongsTo(
                Teacher::class,
                'homeroom_teacher_id'
            );
        }

        public function students()
        {
            return $this->hasMany(Student::class);
        }
}
