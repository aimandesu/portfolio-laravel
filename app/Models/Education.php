<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'location', 
        'level', 
        'achievement',
    ];
    
    public function files()
    {
        return $this->hasOne(Files::class, 'education_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isLocationGiven($location){
        return !$location || trim($location) === '';
    }

}
