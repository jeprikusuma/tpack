<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pretest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'duration_minutes',
        'is_active',
    ];

     protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function attempts()
    {
        return $this->hasMany(PretestAttempt::class);
    }
}
