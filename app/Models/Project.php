<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ProjectType;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'type',
        'title', 
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class, 'project_id');
    }

    protected $casts = [
        'type' => ProjectType::class,
    ];

}
