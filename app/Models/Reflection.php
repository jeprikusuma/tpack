<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reflection extends Model
{
    protected $fillable = [
        'user_id', 'topic_id',
        'answer1', 'answer2', 'answer3',
        'answer4', 'answer5', 'answer6'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
