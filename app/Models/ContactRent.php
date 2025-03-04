<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRent extends Model
{
    use HasFactory;
    
    protected $table = 'contact_rent';

    protected $fillable = [
        'name',
        'brand_name',
        'email',
        'phone_prefix',
        'phone_number',
        'warehouse',
        'requested_area',
        'message'
    ];
}
