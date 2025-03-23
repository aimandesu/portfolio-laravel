<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $fillable = [
        'files_id', 
        'education_id', 
        'description', 
        'file',
    ];
    
    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
