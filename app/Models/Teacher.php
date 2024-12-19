<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = [];


    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'teacher_stage');
    }
    public function assessments()
    {
        return $this->hasMany(Student_assessment::class);
    }
    // public function classes()
    // {
    //     return $this->belongsToMany(Group::class, 'teacher_classes');
    // }
    public function classes()
{
    return $this->belongsToMany(Group::class, 'teacher_classes', 'teacher_id', 'class_id');
}
 public function getImageAttribute($val)
    {
        return ($val !== null) ? asset( $val) : "";
    }
}
