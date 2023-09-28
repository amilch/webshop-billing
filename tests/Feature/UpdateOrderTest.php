<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Services\RabbitMQService;
use Bschmitt\Amqp\Facades\Amqp;
use Domain\Enums\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery\MockInterface;
use Tests\TestCase;

class UpdateOrderTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    use WithoutMiddleware;

    public function test_should_update_order_with_new_status(): void
    {
        $this->mock(RabbitMQService::class, fn (MockInterface $mock) => $mock
            ->shouldReceive('publish')->once()
        );

        $this->assertEquals(OrderStatus::CREATED, Order::where('id', 0)->first()->getStatus());

        $response = $this->patchJson('/orders/',[
            'id' => 0,
            'status' => OrderStatus::PAYMENT_CONFIRMED,
        ]);
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('status', OrderStatus::PAYMENT_CONFIRMED->value)
                    ->etc()
                )
            );

        $this->assertEquals(OrderStatus::PAYMENT_CONFIRMED, Order::where('id', 0)->first()->getStatus());
    }

    public function test_order_update_should_publish_message(): void
    {
        Amqp::shouldReceive('publish')
            ->once()
            ->withArgs([
                'order_updated',
                '{"id":0,"status":1}'
            ]);

        $this->assertEquals(OrderStatus::CREATED, Order::where('id', 0)->first()->getStatus());

        $response = $this->patchJson('/orders/',[
            'id' => 0,
            'status' => 1,
        ]);
        $response->assertStatus(200);
    }
}
