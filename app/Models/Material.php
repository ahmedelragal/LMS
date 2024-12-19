<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schools()
    {
        return $this->belongsToMany(School::class, 'material_school');
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
     public function getImageAttribute($val)
    {
        return ($val !== null) ? asset($val) : "";
    }
     public function getLearningAttribute($val)
    {
        return ($val !== null) ? asset('ebooks/'.$val) : "";
    }
     public function getHowToUseAttribute($val)
    {
        return ($val !== null) ? asset('ebooks/'. $val) : "";
    }
     public function getFilePathAttribute($val)
    {
        return ($val !== null) ? asset('ebooks/'. $val) : "";
    }
}
