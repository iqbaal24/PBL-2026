<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_address',
        'deadline',
        'notes',
        'total_price',
        'paid_amount',
        'payment_status',
        'status',
        'admin_id',
    ];

    protected $casts = [
        'deadline' => 'date',
        'total_price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(OrderFile::class);
    }

    public function statusHistories(): HasMany  
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}