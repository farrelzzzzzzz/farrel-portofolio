<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'short_description',
        'description',
        'thumbnail',
        'gallery',
        'figma_url',
        'canva_url',
        'model_file',
        'video_file',
        'pdf_file',
        'status',
        'views',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];
}
