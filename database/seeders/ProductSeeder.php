<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory(10)->create();

        $products = [
            [
                'name' => 'ကြက်ကင်',
                'price' => 22000,
                'image' => 'https://i.postimg.cc/Xv8pf17d/1.jpg'
            ],
            [
                'name' => 'ငါးကြင်းပေါင်း',
                'price' => 15000,
                'image' => 'https://i.postimg.cc/3x2yRJsL/123.jpg'
            ],
            [
                'name' => 'အမဲမြေအိုးနှပ်',
                'price' => 12000,
                'image' => 'https://i.postimg.cc/qvQNnZ7n/5.jpg'
            ],
            [
                'name' => 'ငါးကြင်းခေါင်းတုံယမ်း',
                'price' => 7000,
                'image' => 'https://i.postimg.cc/15w6gH6c/3.jpg'
            ],
            [
                'name' => 'မန်ကျီးသီးစိမ်းထောင်း',
                'price' => 10000,
                'image' => 'https://i.postimg.cc/MHj6F9xs/2.jpg'
            ],
            [
                'name' => 'ပါလချောင်ကြော်',
                'price' => 10000,
                'image' => 'https://i.postimg.cc/52Jz8CSc/4.jpg'
            ],

        ];

        foreach ($products as $product) {
            $product = Product::create([
                "name" => $product['name'],
                "actual_price" => $product['price'],
                "primary_unit_id" => 1,
                "primary_price" => $product['price'],
                "stock" => 100,
                "user_id" => 1,
                "image" => $product['image']
            ]);

            $product->categories()->attach(rand(1, 2));
        }
    }
}
