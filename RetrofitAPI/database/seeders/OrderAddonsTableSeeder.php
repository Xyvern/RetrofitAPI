<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderAddonsTableSeeder extends Seeder
{
    public function run()
    {
        $order_addons = [
            ['orderDetailID' => 3, 'addon_name' => 'Less Ice'],
            ['orderDetailID' => 3, 'addon_name' => 'No Sugar'],
        ];
        DB::table('order_addons')->insert($order_addons);
    }
}
