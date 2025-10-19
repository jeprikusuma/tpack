<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosttestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'posttest_id',
        'user_id',
        'start_time',
        'end_time',
        'score',
        'status',
    ];

    public function posttest()
    {
        return $this->belongsTo(Posttest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(PosttestAnswer::class, 'attempt_id');
    }
}
