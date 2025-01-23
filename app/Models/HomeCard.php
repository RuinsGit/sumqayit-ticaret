<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCard extends Model
{
    protected $fillable = [
        'image',
        'image_alt_az',
        'image_alt_en',
        'image_alt_ru',
        'title_az',
        'title_en',
        'title_ru',
        'description_az',
        'description_en',
        'description_ru'
    ];

    public function getTitleAttribute()
    {
        return $this->{'title_' . app()->getLocale()};
    }

    public function getDescriptionAttribute()
    {
        return $this->{'description_' . app()->getLocale()};
    }

    public function getImageAltAttribute()
    {
        return $this->{'image_alt_' . app()->getLocale()};
    }
}
