<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherResource extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
