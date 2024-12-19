<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'assignment_stage');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'assignment_student');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function classes()
    {
        return $this->belongsToMany(Group::class, 'assignment_class', 'assignment_id', 'class_id');
    }
}
