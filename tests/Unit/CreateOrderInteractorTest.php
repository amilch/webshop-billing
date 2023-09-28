<?php

namespace Tests\Unit;

use Domain\Interfaces\OrderFactory;
use Domain\Interfaces\OrderItemEntity;
use Domain\Interfaces\OrderItemFactory;
use Domain\Interfaces\OrderRepository;
use Domain\Services\OrderService;
use Domain\UseCases\CreateOrder\CreateOrderInteractor;
use Domain\UseCases\CreateOrder\CreateOrderMessageOutputPort;
use Domain\UseCases\CreateOrder\CreateOrderOutputPort;
use Domain\UseCases\CreateOrder\CreateOrderRequestModel;
use Domain\ValueObjects\MoneyValueObject;
use Domain\Enums\OrderStatus;
use Domain\Interfaces\OrderEntity;
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
        $message_output = Mockery::mock(CreateOrderMessageOutputPort::class);
        $message_output->shouldReceive('orderCreated')->once();
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

        $interactor = new CreateOrderInteractor(
            $output,
            $message_output,
            $repository,
            $factory,
            $item_factory,
            $order_service,
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
        $message_output = Mockery::mock(CreateOrderMessageOutputPort::class);
        $message_output->shouldReceive('orderCreated')->never();
        $repository = Mockery::Mock(OrderRepository::class);
        $repository->shouldReceive('insert')->never();
        $factory = Mockery::Mock(OrderFactory::class);
        $factory->shouldReceive('make')->never();

        $item_factory = Mockery::Mock(OrderItemFactory::class);
        $item_factory
            ->shouldReceive('make')
            ->andReturn($item)->once();
        $order_service = Mockery::Mock(OrderService::class);
        $order_service
            ->shouldReceive('computeTotal')
            ->with([$item])
            ->andReturn(MoneyValueObject::fromInt(1));

        $interactor = new CreateOrderInteractor(
            $output,
            $message_output,
            $repository,
            $factory,
            $item_factory,
            $order_service,
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
