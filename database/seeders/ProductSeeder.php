<?php

namespace Database\Seeders;

use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = collect([
            [
                'name' => 'ESP32',
                'slug' => 'esp32',
                'code' => 001,
                'quantity' => 10,
                'buying_price' => 100000,
                'rent_price' => 20000,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1,
                'unit_id' => 3,
            ],
            [
                'name' => 'light sensor',
                'slug' => 'lightsensor',
                'code' => 002,
                'quantity' => 10,
                'buying_price' => 20000,
                'rent_price' => 3000,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 2,
                'unit_id' => 3,
            ],
            [
                'name' => 'temp sensor',
                'slug' => 'tempsensor',
                'code' => 003,
                'quantity' => 10,
                    'buying_price' => 900,
                    'rent_price' => 3000,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 2,
                'unit_id' => 3,
            ],
            [
                'name' => 'Arduino Uno R3',
                'slug' => 'uno_r3',
                'code' => 004,
                'quantity' => 10,
                'buying_price' => 200000,
                'rent_price' => 20000,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1,
                'unit_id' => 3,
            ],
            [
                'name' => 'Kabel',
                'slug' => 'kabel_1',
                'code' => 005,
                'quantity' => 10,
                'buying_price' => 500000,
                'rent_price' => 50000,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 4,
                'unit_id' => 3,
            ]
        ]);

        $products->each(function ($product){
            Product::create($product);
        });
    }
}
