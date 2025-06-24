<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailsTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $order_details = [
            [
                'orderID' => 1,
                'productID' => 1,
                'quantity' => 1,
                'price' => 45000,
                'addon' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'orderID' => 1,
                'productID' => 2,
                'quantity' => 1,
                'price' => 35000,
                'addon' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'orderID' => 2,
                'productID' => 4,
                'quantity' => 1,
                'price' => 20000,
                'addon' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'orderID' => 3,
                'productID' => 5,
                'quantity' => 2,
                'price' => 15000,
                'addon' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'orderID' => 3,
                'productID' => 6,
                'quantity' => 1,
                'price' => 18000,
                'addon' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        
        DB::table('order_details')->insert($order_details);
    }
}