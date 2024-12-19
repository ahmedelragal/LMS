<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    // public function teachers()
    // {
    //     return $this->belongsToMany(TeacherClass::class);
    // }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_classes', 'class_id', 'teacher_id');
    }
    public function assignments()
{
    return $this->belongsToMany(Assignment::class, 'assignment_class', 'class_id', 'assignment_id');
}

    public function getImageAttribute($val)
    {
        return ($val !== null) ? asset($val) : "";
    }
}
