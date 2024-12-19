<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationQuestion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function header()
    {
        return $this->belongsTo(ObservationHeader::class);
    }
}
