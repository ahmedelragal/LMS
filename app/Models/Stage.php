<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_stage');
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_stage');
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_stage');
    }
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function classes()
    {
        return $this->hasMany(Group::class);
    }

    
     public function getImageAttribute($val)
    {
        return ($val !== null) ? asset( $val) : "";
    }
    

}
