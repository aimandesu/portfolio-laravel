<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable =['user_id', 'name', 'current_title', 'location', 'image', 'address', 'email'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id', 'project_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'user_id', 'experience_id');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'user_id', 'skill_id');
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'user_id', 'education_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
