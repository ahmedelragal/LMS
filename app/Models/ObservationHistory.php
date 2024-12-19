<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationHistory extends Model
{
    use HasFactory;
    // observation_id,question_id
    protected $guarded = [];


    public function observation()
    {
        return $this->belongsTo(Observation::class);
    }
    public function observation_question()
    {
        return $this->belongsTo(ObservationQuestion::class);
    }
}
