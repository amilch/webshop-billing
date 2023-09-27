<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetOrdersTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    public function test_can_return_all_orders(): void
    {
        $response = $this->getJson('/orders');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', 1, fn (AssertableJson $json) => $json
                    ->whereType('id', 'integer')
                    ->whereType('created', 'string')
                    ->whereType('status', 'integer')
                    ->whereType('shipping_cost', 'string')
                    ->whereType('total', 'string')
                    ->whereType('shipping_address', 'string')
                    ->whereType('payment_data', 'string')
                    ->whereType('mail', 'string')
                    ->has('items', 2, fn (AssertableJson $json) => $json
                        ->whereType('sku', 'string')
                        ->whereType('quantity', 'integer')
                    )
                )
            );
    }

    public function test_returns_empty_if_no_orders(): void
    {
        Order::truncate();

        $response = $this->getJson('/orders');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('data', [])
            );
    }
}
