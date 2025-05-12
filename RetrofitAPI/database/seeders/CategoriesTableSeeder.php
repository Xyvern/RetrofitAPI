<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Foods', 'description' => "All kinds of healty foods"],
            ['name' => 'Beverages', 'description' => "All kinds of healthy beverages"],
            ['name' => 'Snacks', 'description' => "All kinds of healthy snacks"]
        ];
        DB::table('categories')->insert($categories);
    }
}
