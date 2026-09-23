<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'LPG Cylinder 11kg',
            'gas_price' => 950.00,
            'cylinder_fee' => 1500.00,
            'current_stock' => 35,
            'max_capacity' => 50,
            'reorder_level' => 20,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'LPG Cylinder 22kg',
            'gas_price' => 1850.00,
            'cylinder_fee' => 1500.00,
            'current_stock' => 18,
            'max_capacity' => 50,
            'reorder_level' => 20,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'LPG Cylinder 50kg',
            'gas_price' => 4200.00,
            'cylinder_fee' => 1500.00,
            'current_stock' => 8,
            'max_capacity' => 50,
            'reorder_level' => 20,
            'is_active' => true,
        ]);
    }
}
