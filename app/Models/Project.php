<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'user_id', 'title', 'description', 'image_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'project_id');
    }

    public function image()
    {
        return $this->belongsTo(ProjectImage::class, 'image_id', 'project_id');
    }
}
