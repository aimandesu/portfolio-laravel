<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = ['experience_id', 'user_id', 'title', 'location', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'experience_id');
    }
}