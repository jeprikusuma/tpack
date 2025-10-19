<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'num',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pretests(){
        return $this->hasMany(PretestAttempt::class);
    }
    
    public function contentProgress(){
        return $this->hasMany(ContentProgress::class);
    }
    
    public function discussions(){
        return $this->hasMany(Discussion::class);
    }
    
    public function reflections(){
        return $this->hasMany(Reflection::class);
    }

    public function perceptionResponse()
    {
        return $this->hasOne(PerceptionResponse::class, 'student_id');
    }

}
