<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = ['skill_id', 'user_id', 'name', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'skill_id');
    }
}
