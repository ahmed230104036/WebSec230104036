<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'code' => 'TV01',
                'name' => 'LG TV 50 Inch',
                'price' => 28000,
                'model' => 'LG8768787',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'photo' => 'lgtv50.jpg',
            ],
            [
                'code' => 'RF01',
                'name' => 'Toshiba Refrigerator 14"',
                'price' => 22000,
                'model' => 'TS76634',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'photo' => 'tsrf50.jpg',
            ],
            [
                'code' => 'TV02',
                'name' => 'LG TV 55"',
                'price' => 23000,
                'model' => 'LG8768787',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'photo' => 'tv2.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
