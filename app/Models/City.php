<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    public $incrementing = false;
    protected $fillable = ['id', 'province_id', 'name', 'type', 'postal_code'];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'default_city_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'shipping_city_id');
    }
}
