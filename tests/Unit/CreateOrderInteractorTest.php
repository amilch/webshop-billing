<?php

namespace Tests\Unit;

use Domain\Entities\Order\OrderEntity;
use Domain\Entities\Order\OrderFactory;
use Domain\Entities\Order\OrderRepository;
use Domain\Entities\OrderItem\OrderItemEntity;
use Domain\Entities\OrderItem\OrderItemFactory;
use Domain\Enums\OrderStatus;
use Domain\Events\EventService;
use Domain\Events\OrderCreated\OrderCreatedEventFactory;
use Domain\Services\OrderService;
use Domain\Services\ReserveItemsService;
use Domain\UseCases\CreateOrder\CreateOrderInteractor;
use Domain\UseCases\CreateOrder\CreateOrderMessageOutputPort;
use Domain\UseCases\CreateOrder\CreateOrderOutputPort;
use Domain\UseCases\CreateOrder\CreateOrderRequestModel;
use Domain\ValueObjects\MoneyValueObject;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class CreateOrderInteractorTest extends TestCase
{
    use MockeryPHPUnitIntegration; // else mock expectations are not counted as assertions
    /**
     * A basic unit test example.
     */
    public function test_returns_computes_and_saves_total(): void
    {
        $item = Mockery::mock(OrderItemEntity::class);
        $item->shouldReceive('getSku')->andReturn('test_sku');
        $item->shouldReceive('getQuantity')->andReturn(1);
        $order = Mockery::mock(OrderEntity::class);
        $order->shouldReceive('add')->with($item);
        $order->shouldReceive('getId')->andReturn(0);

        $output = Mockery::mock(CreateOrderOutputPort::class);
        $output->shouldReceive('orderCreated')->once();

        $event_service = Mockery::mock(EventService::class);
        $event_service->shouldReceive('publish')->once();

        $event_factory = Mockery::mock(OrderCreatedEventFactory::class);
        $event_factory->shouldReceive('make')->once();

        $repository = Mockery::Mock(OrderRepository::class);
        $repository->shouldReceive('insert')
            ->with($order)->once()->andReturn($order)->once();
        $factory = Mockery::Mock(OrderFactory::class);
        $factory->shouldReceive('make')
            ->with([
                'status' => OrderStatus::CREATED,
                'shipping_cost' => MoneyValueObject::fromInt(0),
                'total' => MoneyValueObject::fromInt(230),
                'shipping_address' => 'address',
                'payment_data' => 'payment',
                'mail' => 'mail@webshop.local',
            ])->andReturn($order)->once();

        $item_factory = Mockery::Mock(OrderItemFactory::class);
        $item_factory
            ->shouldReceive('make')
            ->andReturn($item)->once();
        $order_service = Mockery::Mock(OrderService::class);
        $order_service
            ->shouldReceive('computeTotal')
            ->with([$item])
            ->andReturn(MoneyValueObject::fromInt(230));

        $reserve_service = Mockery::Mock(ReserveItemsService::class);
        $reserve_service->shouldReceive('reserveItems')
            ->once()->andReturn(true);

        $interactor = new CreateOrderInteractor(
            $output,
            $repository,
            $factory,
            $item_factory,
            $order_service,
            $event_service,
            $event_factory,
            $reserve_service
        );

        $interactor->createOrder(new CreateOrderRequestModel([
            'items' => [
                [
                    'sku' => 'test_sku',
                    'quantity' => 1,
                ],
            ],
            'shipping_address' => 'address',
            'payment_data' => 'payment',
            'total' => '2,30',
            'mail' => 'mail@webshop.local'
        ]));
    }

    public function test_returns_error_when_price_changed(): void
    {
        $item = Mockery::mock(OrderItemEntity::class);
        $order = Mockery::mock(OrderEntity::class);

        $output = Mockery::mock(CreateOrderOutputPort::class);
        $output->shouldReceive('unableToCreateOrder')->once();
        $repository = Mockery::Mock(OrderRepository::class);
        $repository->shouldReceive('insert')->never();
        $factory = Mockery::Mock(OrderFactory::class);
        $factory->shouldReceive('make')->never();

        $event_service = Mockery::mock(EventService::class);
        $event_service->shouldReceive('publish')->never();

        $event_factory = Mockery::mock(OrderCreatedEventFactory::class);
        $event_factory->shouldReceive('make')->never();

        $item_factory = Mockery::Mock(OrderItemFactory::class);
        $item_factory
            ->shouldReceive('make')
            ->andReturn($item)->once();
        $order_service = Mockery::Mock(OrderService::class);
        $order_service
            ->shouldReceive('computeTotal')
            ->with([$item])
            ->andReturn(MoneyValueObject::fromInt(1));

        $reserve_service = Mockery::Mock(ReserveItemsService::class);
        $reserve_service->shouldReceive('reserveItems')->never();

        $interactor = new CreateOrderInteractor(
            $output,
            $repository,
            $factory,
            $item_factory,
            $order_service,
            $event_service,
            $event_factory,
            $reserve_service
        );

        $view_model = $interactor->createOrder(new CreateOrderRequestModel([
            'items' => [
                [
                    'sku' => 'test_sku',
                    'quantity' => 1,
                ],
            ],
            'shipping_address' => 'address',
            'payment_data' => 'payment',
            'total' => '2,30',
            'mail' => 'mail@webshop.local'
        ]));
    }
}
