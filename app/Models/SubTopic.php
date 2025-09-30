<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTopic extends Model
{
    protected $fillable = [
        'title',
        'topic_id'
    ];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function contents(){
        return $this->hasMany(Content::class);
    }
}
