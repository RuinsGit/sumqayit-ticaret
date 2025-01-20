<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    protected $table = 'gallery_images';

    protected $fillable = [
        'title_az',
        'title_en',
        'title_ru',
        'slug_az',
        'slug_en',
        'slug_ru',
        'description_az',
        'description_en',
        'description_ru',
        'main_image',
        'main_image_alt_az',
        'main_image_alt_en',
        'main_image_alt_ru',
        'bottom_image',
        'bottom_image_alt_az',
        'bottom_image_alt_en',
        'bottom_image_alt_ru',
        'multiple_images',
        'gallery_type_id',
        'meta_title_az',
        'meta_title_en',
        'meta_title_ru',
        'meta_description_az',
        'meta_description_en',
        'meta_description_ru'
    ];

    protected $casts = [
        'multiple_images' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($gallery) {
            $gallery->slug_az = $gallery->createSlug($gallery->title_az, 'az');
            $gallery->slug_en = $gallery->createSlug($gallery->title_en, 'en');
            $gallery->slug_ru = $gallery->createSlug($gallery->title_ru, 'ru');
        });

        static::updating(function ($gallery) {
            if ($gallery->isDirty('title_az')) {
                $gallery->slug_az = $gallery->createSlug($gallery->title_az, 'az');
            }
            if ($gallery->isDirty('title_en')) {
                $gallery->slug_en = $gallery->createSlug($gallery->title_en, 'en');
            }
            if ($gallery->isDirty('title_ru')) {
                $gallery->slug_ru = $gallery->createSlug($gallery->title_ru, 'ru');
            }
        });
    }

    private function createSlug($title, $lang)
    {
        $slug = Str::slug($title);
        $count = static::where("slug_$lang", 'LIKE', $slug . '%')
            ->where('id', '!=', $this->id)
            ->count();
        
        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function galleryType()
    {
        return $this->belongsTo(GalleryType::class);
    }
} 