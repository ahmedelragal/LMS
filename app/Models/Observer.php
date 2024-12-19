<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Observer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Guarded attributes
    protected $guarded = [];

    // Hidden attributes for serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function observation()
    {
        return $this->hasMany(Observation::class);
    }
}
