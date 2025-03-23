<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'user_id', 'title', 'description', ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'project_id');
    }

    public function image()
    {
        return $this->hasMany(ProjectImage::class, 'project_id', 'image_id');
    }
}
