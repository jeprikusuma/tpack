<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerceptionResponse extends Model
{
    protected $fillable = [
        'student_id',
        'total_score',
    ];

    /**
     * Relasi ke mahasiswa (user)
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relasi ke semua jawaban mahasiswa
     */
    public function answers()
    {
        return $this->hasMany(PerceptionAnswer::class, 'response_id');
    }
}
