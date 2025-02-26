<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'image_alt_az',
        'image_alt_en',
        'image_alt_ru',
        'name_az',
        'name_en',
        'name_ru',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function getNameAttribute()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function getImageAltAttribute()
    {
        return $this->{'image_alt_' . app()->getLocale()};
    }
} 