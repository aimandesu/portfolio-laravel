<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $fillable = ['education_id', 'user_id', 'location', 'level', 'achievement'];
    
    public function files()
    {
        return $this->hasMany(Files::class, 'education_id', 'education_id');
    }
}
