<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetTotalTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_return_correct_sum_of_products(): void
    {
        Http::fake(fn (Request $request) =>
        Http::response('
{
	"data": [
		{
			"id": 2,
			"category_id": 2,
			"name": "Basilikum Samen",
			"sku": "basilikum_samen",
			"description": "Verleihen Sie Ihren kulinarischen Kreationen mit dem aromatischen Geschmack von frischem Basilikum das gewisse Etwas. Diese Samen ergeben duftende Basilikumblätter, ideal für Pasta, Pesto und mehr.",
			"price": "1,69",
			"in_stock": true
		},
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

        $response = $this->postJson('/total', [
            'items' => [
                [
                    'sku' => 'kirsch_tomaten_samen',
                    'quantity' => 2
                ],
                [
                    'sku' => 'basilikum_samen',
                    'quantity' => 3
                ],
            ]
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('total', '10,05')
                )
            );
    }

    public function test_return_zero_if_no_products_given(): void
    {
        $response = $this->postJson('/total', [
            'items' => []
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('total', '0,00')
                )
            );
    }
}
