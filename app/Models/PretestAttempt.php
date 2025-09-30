<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'pretest_id',
        'user_id',
        'start_time',
        'end_time',
        'score',
        'status',
    ];

    public function pretest()
    {
        return $this->belongsTo(Pretest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(PretestAnswer::class, 'attempt_id');
    }
}
