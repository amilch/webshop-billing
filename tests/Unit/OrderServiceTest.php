<?php

namespace Tests\Unit;

use Domain\Entities\OrderItem\OrderItemEntity;
use Domain\Exceptions\ProductsNotAvailableException;
use Domain\Services\OrderService;
use Domain\Services\QueryPriceService;
use Domain\ValueObjects\MoneyValueObject;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_total_is_zero_with_no_items(): void
    {
        $query_price_service = Mockery::mock(QueryPriceService::class);
        $query_price_service
            ->shouldReceive('pricesForProducts')
            ->andReturn([]);

        $order_service = new OrderService($query_price_service);

        $this->assertEquals(
            MoneyValueObject::fromInt(0),
            $order_service->computeTotal([])
        );
    }

    public function test_total_is_product_price_with_one_product(): void
    {
        $query_price_service = Mockery::mock(QueryPriceService::class);
        $query_price_service
            ->shouldReceive('pricesForProducts')
            ->andReturn([
                MoneyValueObject::fromInt(200),
            ]);

        $item = Mockery::mock(OrderItemEntity::class);
        $item->shouldReceive('getQuantity')
              ->andReturn(1);
        $item->shouldReceive('getSku')
              ->andReturn('test_sku');

        $order_service = new OrderService($query_price_service);



        $this->assertEquals(
            MoneyValueObject::fromInt(200),
            $order_service->computeTotal([$item])
        );
    }

    public function test_can_compute_total_for_multiple_products_and_quantities(): void
    {
        $query_price_service = Mockery::mock(QueryPriceService::class);
        $query_price_service
            ->shouldReceive('pricesForProducts')
            ->andReturn([
                MoneyValueObject::fromInt(200),
                MoneyValueObject::fromInt(300),
            ]);

        $item = Mockery::mock(OrderItemEntity::class);
        $item->shouldReceive('getQuantity')
              ->andReturn(5);
        $item->shouldReceive('getSku')
              ->andReturn('test_sku');
        $item2 = Mockery::mock(OrderItemEntity::class);
        $item2->shouldReceive('getQuantity')
              ->andReturn(3);
        $item2->shouldReceive('getSku')
              ->andReturn('test_sku_2');

        $order_service = new OrderService($query_price_service);

        $this->assertEquals(
            MoneyValueObject::fromInt(5*200+3*300),
            $order_service->computeTotal([$item, $item2])
        );
    }

    public function test_throw_exception_when_product_sku_is_not_found(): void
    {
        $query_price_service = Mockery::mock(QueryPriceService::class);
        $query_price_service
            ->shouldReceive('pricesForProducts')
            ->andReturn([]);

        $item = Mockery::mock(OrderItemEntity::class);
        $item->shouldReceive('getQuantity')
              ->andReturn(5);
        $item->shouldReceive('getSku')
              ->andReturn('test_sku');

        $order_service = new OrderService($query_price_service);

        $this->expectException(ProductsNotAvailableException::class);
        $order_service->computeTotal([$item]);
    }
}
