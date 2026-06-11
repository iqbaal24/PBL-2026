<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProfile extends Model
{
    use HasFactory;

    protected $table = 'store_profile';

    protected $fillable = [
        'name',
        'about',
        'address',
        'maps_url',
        'maps_embed_url',
        'whatsapp_number',
        'email',
        'logo',
        'instagram_url',
    ];
}