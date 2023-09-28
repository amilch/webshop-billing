<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = '2023-09-27 16:12:21';

        DB::table('order_items')->insert([
            'id' => 1,
            'order_id' => 1,
            'sku' => 'kirsch_tomaten_samen',
            'quantity' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('order_items')->insert([
            'id' => 2,
            'order_id' => 1,
            'sku' => 'basilikum_samen',
            'quantity' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
