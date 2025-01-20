<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeAbout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title1_az', 'title1_en', 'title1_ru',
        'title2_az', 'title2_en', 'title2_ru',
        'special_title1_az', 'special_title1_en', 'special_title1_ru',
        'special_title2_az', 'special_title2_en', 'special_title2_ru',
        'special_title3_az', 'special_title3_en', 'special_title3_ru',
        'images', 'images_alt_az', 'images_alt_en', 'images_alt_ru'
    ];


    protected $casts = [
        'images' => 'array',
        'images_alt_az' => 'array',
        'images_alt_en' => 'array',
        'images_alt_ru' => 'array'
    ];
}
