<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_az',
        'title_en',
        'title_ru',
        'slug_az',
        'slug_en',
        'slug_ru',
        'main_video',
        'main_video_thumbnail',
        'main_video_alt_az',
        'main_video_alt_en',
        'main_video_alt_ru',
        'bottom_video',
        'bottom_video_thumbnail',
        'bottom_video_alt_az',
        'bottom_video_alt_en',
        'bottom_video_alt_ru',
        'multiple_videos',
        'meta_title_az',
        'meta_title_en',
        'meta_title_ru',
        'meta_description_az',
        'meta_description_en',
        'meta_description_ru'
    ];

    protected $casts = [
        'multiple_videos' => 'array'
    ];
}
