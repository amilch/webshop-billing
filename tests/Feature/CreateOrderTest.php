<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Services\RabbitMQService;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Http\Client\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();

        Http::fake(fn (Request $request) =>
        Http::response('
        {
            "data": [
                {
                    "id": 1,
                    "category_id": 1,
                    "name": "Kirsch-Tomaten Samen",
                    "sku": "kirsch_tomaten_samen",
                    "description": "Züchten Sie Ihre eigenen süßen und saftigen Kirschtomaten mit diesen hochwertigen Samen. Perfekt für Salate, Snacks und frische Garten-Tisch-Gerichte.",
                    "price": "2,49",
                    "in_stock": true
                }
            ]
        }
            ', 200)
        );


    }

    public function test_should_return_error_when_total_price_mismatch(): void
    {
        $this->mock(RabbitMQService::class, fn (MockInterface $mock) => $mock
            ->shouldReceive('publish')->never()
        );

        $response = $this->postJson('/orders',[
            'items' => [
                [
                    'name' => 'Kirsch-Tomaten Samen',
                    'price' => '2,49',
                    'quantity' => 2,
                    'sku' => 'kirsch_tomaten_samen'
                ]
            ],
            'mail' => 'mail@webshop.local',
            'shipping_address' => '{"first_name":"Leo","last_name":"Doe","street_nr":"Straße. 123","plz":"12345","city":"Berlin"}',
            'payment_data' => '{"first_name":"Leo","last_name":"Doe","iban":"DEIBANIBANIBAN"}',
            'total' => '1,00',
        ]);
        $response
            ->assertStatus(409)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->whereType('message', 'string')
                )
            );
    }

    public function test_should_create_order_when_price_matches(): void
    {
        $this->mock(RabbitMQService::class, fn (MockInterface $mock) => $mock
            ->shouldReceive('publish')->once()
        );

        $response = $this->postJson('/orders',[
            'items' => [
                [
                'name' => 'Kirsch-Tomaten Samen',
                'price' => '2,49',
                'quantity' => 2,
                'sku' => 'kirsch_tomaten_samen'
                ]
            ],
            'mail' => 'mail@webshop.local',
            'shipping_address' => '{"first_name":"Leo","last_name":"Doe","street_nr":"Straße. 123","plz":"12345","city":"Berlin"}',
            'payment_data' => '{"first_name":"Leo","last_name":"Doe","iban":"DEIBANIBANIBAN"}',
            'total' => '4,98',
        ]);
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->whereType('created', 'string')
                    ->whereType('status', 'integer')
                    ->whereType('shipping_cost', 'string')
                    ->whereType('total', 'string')
                    ->whereType('shipping_address', 'string')
                    ->whereType('payment_data', 'string')
                    ->whereType('mail', 'string')
                    ->has('items', 1)
                )
            );

        $order = Order::all()->last();
        $this->assertEquals('mail@webshop.local', $order->getMail());
        $this->assertEquals(MoneyValueObject::fromString('4,98'), $order->getTotal());
    }
}
