<?php

namespace App\Models;

use Domain\Entities\OrderItem\OrderItemEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model implements OrderItemEntity
{
    protected $fillable = [
        'order_id',
        'sku',
        'quantity',
    ];

    protected $casts = [
        'id' => 'integer'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getSku(): string
    {
        return $this->attributes['sku'];
    }

    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }
}
