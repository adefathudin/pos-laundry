<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->insert([
            [
            'name' => 'Product 1',
            'description' => 'Description for Product 1',
            'price' => 10000,
            'stock' => 50,
            'image' => 'product1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Product 2',
            'description' => 'Description for Product 2',
            'price' => 20000,
            'stock' => 30,
            'image' => 'product2.jpg',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Product 3',
            'description' => 'Description for Product 3',
            'price' => 15000,
            'stock' => 20,
            'image' => 'product3.jpg',
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);
    }
}
