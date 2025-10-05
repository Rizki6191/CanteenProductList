<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CanteenProduct;

class CanteenProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CanteenProduct::create([
            'name' => 'susu almond',
            'price' => 12000,
            'stock' => 20,
            'category' => 'beverage'
        ]);
        CanteenProduct::create([
            'name' => 'dimsum',
            'price' => 3000,
            'stock' => 50,
            'category' => 'food'
        ]);
        CanteenProduct::create([
            'name' => 'nasi goreng',
            'price' => 12000,
            'stock' => 20,
            'category' => 'food'
        ]);
    }
}
