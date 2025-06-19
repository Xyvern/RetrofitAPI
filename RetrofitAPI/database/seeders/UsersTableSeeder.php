<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'phone' => '1234567890',
                'address' => '123 Main St, Example City',
                'postcode' => '60182',
                'pfp_url' => 'https://example.com/profile.jpg',
                'role' => 1,
                'credit' => 150000.00,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password456'),
                'phone' => '0987654321',
                'address' => '456 Oak Rd, Sample Town',
                'postcode' => '60235',
                'pfp_url' => 'https://example.com/profile2.jpg',
                'role' => 2,
                'credit' => 0.00,
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'phone' => '1122334455',
                'address' => '789 Pine Ln, Admin City',
                'postcode' => '60217',
                'pfp_url' => 'https://example.com/admin-profile.jpg',
                'role' => 3,
                'credit' => 0.00,
            ],
            [
                'name' => 'Sipen',
                'email' => 'kurir@example.com',
                'password' => Hash::make('kurir123'),
                'phone' => '1122334455',
                'address' => '789 Pine Ln, Admin City',
                'postcode' => '60217',
                'pfp_url' => 'https://example.com/admin-profile.jpg',
                'role' => 4,
                'credit' => 0.00,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
