<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function subtopics(){
        return $this->hasMany(SubTopic::class);
    }
    
    public function discussions(){
        return $this->hasMany(Discussion::class);
    }
    
    public function reflections(){
        return $this->hasMany(Reflection::class);
    }
}
