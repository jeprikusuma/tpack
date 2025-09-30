<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'user_id',
        'parent_id',
        'message',
    ];
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Discussion::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Discussion::class, 'parent_id');
    }
}
