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
                'name' => 'ရေဦးပဲငပိ',
                'image' => 'https://api.kyimeldrive.com/storage/images/7oQUsxU76OoNnKLFi7YTz1QyrQmuTRWK2mqXtAoQ.jpg',
                'price' => 2500
            ],
            [
                'name' => 'ပါကင်ထုတ်ခ',
                'image' => 'https://api.kyimeldrive.com/storage/images/4RgTtONgxugljfreSD2AZOTdkdaALHgx6EXSHCZR.jpg',
                'price' => 1500
            ],
            [
                'name' => 'ကရင်ငပိချက်',
                'image' => 'https://api.kyimeldrive.com/storage/images/SJi1R5TTN3Km8QUU5R8RuLcarj2zS57eJgJrn7FS.jpg',
                'price' => 6000
            ],
            [
                'name' => 'ငါးခေါင်းငပိချက်',
                'image' => 'https://api.kyimeldrive.com/storage/images/MbC2OhNrrunomI1PdCbIhfNWGdhATGAOhNPu2wGX.jpg',
                'price' => 4000
            ],
            [
                'name' => 'ရခိုင်ငပိထောင်း',
                'image' => 'https://api.kyimeldrive.com/storage/images/AJBhGVbsS8U8GiAlmoVowO6n8mtTgcL9kKYnnOyV.jpg',
                'price' => 1500
            ],
            [
                'name' => 'ဝက်သားနီချက်',
                'image' => 'https://api.kyimeldrive.com/storage/images/tlr8SjZTFKAYtYcRBoCfmZ4og7WPPovruhMfJ5ME.jpg',
                'price' => 10000
            ],
            [
                'name' => 'ဘဲဥသီးစုံဟင်း',
                'image' => 'https://api.kyimeldrive.com/storage/images/hhwREDW20ChhLC11Z5lGI4tEEWwMvkNzoamLBHvr.jpg',
                'price' => 5000
            ],
            [
                'name' => 'ငါးခူကြော်နှပ်',
                'image' => 'https://api.kyimeldrive.com/storage/images/cFZH5TY9L0yN3DuwDXXo3N998wY8ahIivaPPqSHp.jpg',
                'price' => 15000
            ],
            [
                'name' => 'ပဲတီချဉ်',
                'image' => 'https://i.postimg.cc/PrdNTr8y/photo-2024-02-03-20-49-42.jpg',
                'price' => 1000
            ],
            [
                'name' => 'ငါးခေါင်းတုံယမ်း',
                'image' => 'https://i.postimg.cc/15w6gH6c/3.jpg',
                'price' => 7000
            ],
            [
                'name' => 'မန်ကျည်း',
                'image' => 'https://i.postimg.cc/MHj6F9xs/2.jpg',
                'price' => 10000
            ],
            [
                'name' => 'ပါလခေါင်ကြော်',
                'image' => 'https://i.postimg.cc/52Jz8CSc/4.jpg',
                'price' => 10000
            ],
            [
                'name' => 'အမဲမြေအိုးနှပ်',
                'image' => 'https://i.postimg.cc/qvQNnZ7n/5.jpg',
                'price' => 12000
            ]
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