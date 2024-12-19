<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;
    // school_id,material_id,stage_id,teacher_id,observer_id
    protected $guarded = [];
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function subject()
    {
        return $this->belongsTo(Material::class);
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function observer()
    {
        return $this->belongsTo(Observer::class);
    }
}
