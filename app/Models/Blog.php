<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_az',
        'title_en',
        'title_ru',
        'slug_az',
        'slug_en',
        'slug_ru',
        'text_az',
        'text_en',
        'text_ru',
        'description_1_az',
        'description_1_en',
        'description_1_ru',
        'description_2_az',
        'description_2_en',
        'description_2_ru',
        'main_image',
        'main_image_alt_az',
        'main_image_alt_en',
        'main_image_alt_ru',
        'bottom_images',
        'bottom_images_alt_az',
        'bottom_images_alt_en',
        'bottom_images_alt_ru',
        'meta_title_az',
        'meta_title_en',
        'meta_title_ru',
        'meta_description_az',
        'meta_description_en',
        'meta_description_ru',
        'color'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            $blog->slug_az = $blog->generateUniqueSlug($blog->title_az, 'az');
            $blog->slug_en = $blog->generateUniqueSlug($blog->title_en, 'en');
            $blog->slug_ru = $blog->generateUniqueSlug($blog->title_ru, 'ru');
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title_az')) {
                $blog->slug_az = $blog->generateUniqueSlug($blog->title_az, 'az');
            }
            if ($blog->isDirty('title_en')) {
                $blog->slug_en = $blog->generateUniqueSlug($blog->title_en, 'en');
            }
            if ($blog->isDirty('title_ru')) {
                $blog->slug_ru = $blog->generateUniqueSlug($blog->title_ru, 'ru');
            }
        });
    }

    protected function generateUniqueSlug($title, $lang)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where("slug_$lang", $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
