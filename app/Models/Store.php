<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_type_id',
        'market_id',
        'image',
        'image_alt_az',
        'image_alt_en',
        'image_alt_ru',
        'bottom_image',
        'bottom_image_alt_az',
        'bottom_image_alt_en',
        'bottom_image_alt_ru',
        'description_az',
        'description_en',
        'description_ru',
        'working_hours_az',
        'working_hours_en',
        'working_hours_ru',
        'working_hours_image',
        'number',
        'number_image',
        'email',
        'email_image',
        'link',
        'link_image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function storeType()
    {
        return $this->belongsTo(StoreType::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function getDescriptionAttribute()
    {
        return $this->{'description_' . app()->getLocale()};
    }

    public function getWorkingHoursAttribute()
    {
        return $this->{'working_hours_' . app()->getLocale()};
    }

    public function getImageAltAttribute()
    {
        return $this->{'image_alt_' . app()->getLocale()};
    }

    public function getBottomImageAltAttribute()
    {
        return $this->{'bottom_image_alt_' . app()->getLocale()};
    }
    
}
