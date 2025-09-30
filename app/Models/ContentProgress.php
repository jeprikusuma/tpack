<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentProgress extends Model
{
    protected $fillable = ['user_id', 'content_id', 'is_read', 'read_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function content() {
        return $this->belongsTo(Content::class);
    }

    public function content_progress() {
        return $this->hasMany(ContentProgress::class);
    }
}
