<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingsTableSeeder extends Seeder
{
public function run()
    {
        $now = Carbon::now();

        $ratings = [
            [
                'userID' => 1,
                'productID' => 1,
                'orderDetailID' => 1,
                'rating' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'userID' => 1,
                'productID' => 2,
                'orderDetailID' => 2,
                'rating' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'userID' => 2,
                'productID' => 4,
                'orderDetailID' => 3,
                'rating' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'userID' => 1,
                'productID' => 5,
                'orderDetailID' => 4,
                'rating' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'userID' => 1,
                'productID' => 6,
                'orderDetailID' => 5,
                'rating' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('ratings')->insert($ratings);
    }
}
