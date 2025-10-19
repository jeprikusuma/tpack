<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerceptionAnswer extends Model
{
    protected $fillable = [
        'response_id',
        'question_number',
        'answer',
        'score',
    ];

    /**
     * Relasi ke response utama
     */
    public function response()
    {
        return $this->belongsTo(PerceptionResponse::class, 'response_id');
    }
}
