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
    protected $fillable =[
        'name', 
        'title', 
        'about', 
        'location', 
        'image', 
        'address', 
        'email',
        'password',
    ];

    public function project()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function experience()
    {
        return $this->hasMany(Experience::class, 'user_id');
    }

    public function skill()
    {
        return $this->hasMany(Skill::class, 'user_id');
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'user_id');
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

    public function isEmailAlreadyUsed($email)
    {
        return self::where('email', $email)->exists();
    }

    public function isPasswordLess($password)
    {
        return strlen($password) < 6;
    }

}
