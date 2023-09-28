<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = '2023-09-27 16:12:21';

        DB::table('orders')->insert([
            'id' => 0,
            'mail' => 'mail@webshop.local',
            'status' => 0,
            'shipping_cost' => 0,
            'total' => 418,
            'shipping_address' => '{"first_name":"Leo","last_name":"Doe","street_nr":"Straße der Pariser Kommune 123","plz":"10299","city":"Berlin"}',
            'payment_data' => '{"first_name":"Leo","last_name":"Doe","iban":"DE75512108001245126199"}',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
