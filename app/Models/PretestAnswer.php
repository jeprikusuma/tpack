<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_number',
        'answer',
        'is_correct',
    ];

    public function attempt()
    {
        return $this->belongsTo(PretestAttempt::class, 'attempt_id');
    }
}
