<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreType extends Model
{
    use HasFactory;

    protected $fillable = [
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
}
