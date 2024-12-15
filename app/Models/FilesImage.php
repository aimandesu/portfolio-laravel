<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_id',
        'files_id',
        'image',
    ];

    public function file()
    {
        return $this->belongsTo(Files::class, 'files_id', 'image_id');
    }
}
