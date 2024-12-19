<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationHeader extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function observation_question()
    {
        return $this->hasMany(ObservationQuestion::class);
    }
}
