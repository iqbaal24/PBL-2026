<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'product_name',
        'variant_name',
        'unit_price',
        'weight',
        'quantity',
        'subtotal',
        'design_file_path',
        'design_brief',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'weight' => 'integer',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
