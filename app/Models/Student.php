<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_student');
    }
    public function studentAssessment()
    {
        return $this->hasMany(Student_assessment::class)->latest(); // Fetch the latest assessments
    }
    public function classes()
    {
        return $this->belongsTo(Group::class, 'class_id');
    }

    // public function studentAssessment()
    // {
    //     return $this->hasMany(Student_assessment::class);
    // }
     public function getImageAttribute($val)
    {
        return ($val !== null) ? asset( $val) : "";
    }
}
