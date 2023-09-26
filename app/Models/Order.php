<?php

namespace App\Models;

use Domain\Enums\OrderStatus;
use Domain\Interfaces\OrderEntity;
use Domain\Interfaces\OrderItemEntity;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model implements OrderEntity
{
    use HasFactory;

    protected $fillable = [
        'status',
        'shipping_cost',
        'total',
        'shipping_address',
        'payment_data',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ---------------------------------------------------------------------
    // ProductEntity methods

    public function getStatus(): OrderStatus
    {
        return OrderStatus::from($this->attributes['status']);
    }

    public function getShippingCost(): MoneyValueObject
    {
        return MoneyValueObject::fromInt($this->attributes['shipping_cost']);
    }

    public function getTotal(): MoneyValueObject
    {
        return MoneyValueObject::fromInt($this->attributes['total']);
    }

    public function getShippingAddress(): string
    {
        return $this->attributes['shipping_address'];
    }

    public function getPaymentData(): string
    {
        return $this->attributes['payment_data'];
    }

    public function add(OrderItemEntity $order_item): void
    {
        $this->items()->save($order_item);
    }

    public function setStatus(OrderStatus $status): void
    {
        $this->attributes['status'] = $status;
        $this->save();
    }

    public function getItems(): array
    {
        return $this->items()->get()->all();
    }
}
