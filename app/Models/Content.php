<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title',
        'description',
        'sub_topic_id'
    ];

    public function subtopic(){
        return $this->belongsTo(SubTopic::class);
    }

    public function progress() {
        return $this->hasMany(ContentProgress::class);
    }
    
    public function progress_by_user() {
        return $this->hasOne(ContentProgress::class);
    }
}
