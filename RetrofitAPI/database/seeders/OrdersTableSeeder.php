<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $orders = [
            [
                'userID' => 1,
                'subtotal' => 85000,
                'prep_time' => 30,
                'shipping_fee' => 10000,
                'total' => 95000,
                'status' => 'completed',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'userID' => 2,
                'subtotal' => 45000,
                'prep_time' => 20,
                'shipping_fee' => 5000,
                'total' => 50000,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'userID' => 1,
                'subtotal' => 30000,
                'prep_time' => 15,
                'shipping_fee' => 5000,
                'total' => 35000,
                'status' => 'shipping',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}
