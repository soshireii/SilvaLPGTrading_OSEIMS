<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Permanent accounts — always seeded, not manageable in-app.
        User::create([
            'name' => 'Jeric Silva',
            'email' => 'owner@silvalpg.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '09171234567',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Cashier Demo',
            'email' => 'cashier@silvalpg.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'phone' => '09179876543',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Delivery staff are NOT permanent — in real use, the owner creates
        // and manages these from Admin ▸ Manage Delivery Staff. This one is
        // only seeded so there's an account to log in and test with locally.
        User::create([
            'name' => 'Delivery Demo',
            'email' => 'delivery@silvalpg.com',
            'password' => Hash::make('password'),
            'role' => 'delivery',
            'phone' => '09175551234',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->call(ProductSeeder::class);
    }
}
