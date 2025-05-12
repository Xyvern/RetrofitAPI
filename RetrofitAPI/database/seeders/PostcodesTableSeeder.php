<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostcodesTableSeeder extends Seeder
{
    public function run(): void
    {
        $postcodes = [
            ['postcodeID' => '60182', 'latitude' => -7.2411464, 'longitude' => 112.706274],
            ['postcodeID' => '60197', 'latitude' => -7.2351242, 'longitude' => 112.6288041],
            ['postcodeID' => '60174', 'latitude' => -7.2509857, 'longitude' => 112.7345789],
            ['postcodeID' => '60122', 'latitude' => -7.2500571, 'longitude' => 112.800124],
            ['postcodeID' => '60225', 'latitude' => -7.2968385, 'longitude' => 112.700315],
            ['postcodeID' => '60235', 'latitude' => -7.3308432, 'longitude' => 112.7241509],
            ['postcodeID' => '60275', 'latitude' => -7.2582212, 'longitude' => 112.7405377],
            ['postcodeID' => '60281', 'latitude' => -7.2663122, 'longitude' => 112.706274],
            ['postcodeID' => '60294', 'latitude' => -7.3391634, 'longitude' => 112.8045928],
            ['postcodeID' => '60232', 'latitude' => -7.3160439, 'longitude' => 112.718192],
            ['postcodeID' => '60221', 'latitude' => -7.3434492, 'longitude' => 112.6764786],
            ['postcodeID' => '60123', 'latitude' => -7.2329241, 'longitude' => 112.7911863],
            ['postcodeID' => '60175', 'latitude' => -7.2384068, 'longitude' => 112.7345789],
            ['postcodeID' => '60211', 'latitude' => -7.3016264, 'longitude' => 112.6332737],
            ['postcodeID' => '60115', 'latitude' => -7.2723024, 'longitude' => 112.7837381],
            ['postcodeID' => '60165', 'latitude' => -7.2108977, 'longitude' => 112.7315995],
            ['postcodeID' => '60293', 'latitude' => -7.3309909, 'longitude' => 112.7688416],
            ['postcodeID' => '60217', 'latitude' => -7.2791977, 'longitude' => 112.6526416],
            ['postcodeID' => '60251', 'latitude' => -7.2613636, 'longitude' => 112.72862],
            ['postcodeID' => '60151', 'latitude' => -7.227878,  'longitude' => 112.7435171],
            ['postcodeID' => '60141', 'latitude' => -7.2425008, 'longitude' => 112.7524553],
            ['postcodeID' => '60111', 'latitude' => -7.2881839, 'longitude' => 112.8165095],
            ['postcodeID' => '60188', 'latitude' => -7.2687436, 'longitude' => 112.6839275],
            ['postcodeID' => '60136', 'latitude' => -7.2529965, 'longitude' => 112.7561795],
            ['postcodeID' => '60187', 'latitude' => -7.2684309, 'longitude' => 112.6898866],
            ['postcodeID' => '60261', 'latitude' => -7.2635671, 'longitude' => 112.7345789],
            ['postcodeID' => '60292', 'latitude' => -7.3242256, 'longitude' => 112.7539449],
            ['postcodeID' => '60228', 'latitude' => -7.3122653, 'longitude' => 112.6943559],
            ['postcodeID' => '60239', 'latitude' => -7.3115597, 'longitude' => 112.751925],
            ['postcodeID' => '60243', 'latitude' => -7.3040018, 'longitude' => 112.7315995],
        ];
        DB::table('postcodes')->insert($postcodes);
    }
}
