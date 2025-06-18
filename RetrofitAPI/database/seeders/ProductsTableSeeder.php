<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
public function run()
    {
        $now = Carbon::now();

        $products = [
            [
                'name' => 'Grilled Salmon Bowl',
                'categoryID' => 1,
                'price' => 45000,
                'rating' => 5.0,
                'description' => 'A balanced bowl with grilled salmon, quinoa, steamed broccoli, and avocado.',
                'img_url' => '-',
                'fat' => 20,
                'calories' => 600,
                'protein' => 30,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Veggie Quinoa Salad',
                'categoryID' => 1,
                'price' => 35000,
                'rating' => 4.0,
                'description' => 'A refreshing mix of quinoa, cherry tomatoes, cucumbers, and olive oil dressing.',
                'img_url' => '-',
                'fat' => 10,
                'calories' => 400,
                'protein' => 12,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Green Detox Smoothie',
                'categoryID' => 2,
                'price' => 25000,
                'rating' => 0.0,
                'description' => 'Smoothie with kale, spinach, green apple, banana, and chia seeds.',
                'img_url' => '-',
                'fat' => 5,
                'calories' => 200,
                'protein' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Cold-Pressed Carrot Juice',
                'categoryID' => 2,
                'price' => 20000,
                'rating' => 5.0,
                'description' => 'Freshly pressed carrot juice with a hint of ginger and lemon.',
                'img_url' => '-',
                'fat' => 0,
                'calories' => 150,
                'protein' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Baked Kale Chips',
                'categoryID' => 3,
                'price' => 15000,
                'rating' => 4.0,
                'description' => 'Crunchy oven-baked kale lightly seasoned with sea salt.',
                'img_url' => '-',
                'fat' => 7,
                'calories' => 100,
                'protein' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Energy Bites',
                'categoryID' => 3,
                'price' => 18000,
                'rating' => 5.0,
                'description' => 'No-bake bites made with oats, peanut butter, honey, and chia seeds.',
                'img_url' => '-',
                'fat' => 8,
                'calories' => 150,
                'protein' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
