<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posttest extends Model
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
        return $this->hasMany(PosttestAttempt::class);
    }

    public function isActive(): bool
    {
        $now = now();
        return ($this->start_date && $this->end_date)
            ? $now->between($this->start_date, $this->end_date)
            : false;
    }
}
