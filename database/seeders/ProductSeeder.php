<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            // First truncate the dependent table (product_units)
            DB::table('product_units')->truncate();
            
            // Then truncate the products table
            DB::table('products')->truncate();

        $products = [
            [
                'id' => 1,
                'image' => 'https://i.postimg.cc/Xv8pf17d/1.jpg',
                'name' => 'ကြက်ကင်',
                'actual_price' => 22000,
                'primary_unit_id' => 9,
                'primary_price' => 27000,
                'promotion_id' => NULL,
                'stock' => 3.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2025-01-09 11:38:13'
            ],
            [
                'id' => 2,
                'image' => 'https://i.postimg.cc/3x2yRJsL/123.jpg',
                'name' => 'ငါးကြင်းပေါင်း',
                'actual_price' => 15000,
                'primary_unit_id' => 1,
                'primary_price' => 16000,
                'promotion_id' => NULL,
                'stock' => 4.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2025-01-09 12:02:33'
            ],
            [
                'id' => 3,
                'image' => 'https://i.postimg.cc/qvQNnZ7n/5.jpg',
                'name' => 'အမဲမြေအိုးနှပ်',
                'actual_price' => 12000,
                'primary_unit_id' => 1,
                'primary_price' => 12000,
                'promotion_id' => NULL,
                'stock' => 88.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-12-18 05:41:37'
            ],
            [
                'id' => 4,
                'image' => 'https://i.postimg.cc/15w6gH6c/3.jpg',
                'name' => 'ငါးခေါင်းတုံယမ်း',
                'actual_price' => 7000,
                'primary_unit_id' => 1,
                'primary_price' => 8000,
                'promotion_id' => NULL,
                'stock' => 4.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2025-01-09 11:21:08'
            ],
            [
                'id' => 5,
                'image' => 'https://i.postimg.cc/MHj6F9xs/2.jpg',
                'name' => 'မန်ကျည်း',
                'actual_price' => 10000,
                'primary_unit_id' => 1,
                'primary_price' => 10000,
                'promotion_id' => NULL,
                'stock' => 0.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-10-24 15:06:36'
            ],
            [
                'id' => 6,
                'image' => 'https://i.postimg.cc/52Jz8CSc/4.jpg',
                'name' => 'ပါလချောင်ကြော်',
                'actual_price' => 10000,
                'primary_unit_id' => 1,
                'primary_price' => 11000,
                'promotion_id' => NULL,
                'stock' => 10.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2025-01-09 11:42:56'
            ],
            [
                'id' => 7,
                'image' => 'images/7Er4KYNY6l7rBncc5Wm9v16YBSTk1UQbngJhDORe.jpg',
                'name' => 'ဆိတ်သားဟင်း',
                'actual_price' => 10000,
                'primary_unit_id' => 1,
                'primary_price' => 15000,
                'promotion_id' => NULL,
                'stock' => 0.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-07 12:20:45',
                'updated_at' => '2025-01-09 11:56:41'
            ],
            [
                'id' => 8,
                'image' => 'images/lZHbokVB7v8j6CRk4ieQDRCSnNfkzQHbhZZ0nNH7.jpg',
                'name' => 'ငါးခြောက်',
                'actual_price' => 10000,
                'primary_unit_id' => 1,
                'primary_price' => 12000,
                'promotion_id' => NULL,
                'stock' => 80.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-09 05:51:54',
                'updated_at' => '2024-09-13 04:49:55'
            ],
            [
                'id' => 9,
                'image' => NULL,
                'name' => 'Sauceပုလင်း',
                'actual_price' => 6000,
                'primary_unit_id' => 1,
                'primary_price' => 7000,
                'promotion_id' => NULL,
                'stock' => 30.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-13 05:02:05',
                'updated_at' => '2024-12-25 12:42:36'
            ],
            [
                'id' => 10,
                'image' => 'images/euToR9T8IEbCalUQSLdj95kORNKZTftN04yCpp9f.jpg',
                'name' => 'သံပုရာသီးသနပ်',
                'actual_price' => 10000,
                'primary_unit_id' => 1,
                'primary_price' => 10000,
                'promotion_id' => NULL,
                'stock' => 7.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-14 11:05:29',
                'updated_at' => '2024-10-07 16:59:19'
            ],
            [
                'id' => 12,
                'image' => 'images/Lozkr0duqRiXvBawetzGjz8JSLMZPqtT2KNA5axD.jpg',
                'name' => 'ပုစွန်ငံပြာရည်ကြော်',
                'actual_price' => 8000,
                'primary_unit_id' => 1,
                'primary_price' => 11000,
                'promotion_id' => NULL,
                'stock' => 7.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-20 03:54:12',
                'updated_at' => '2025-01-09 11:42:56'
            ],
            [
                'id' => 13,
                'image' => 'images/UnVb88PzEJexdowVzMGn18oBifqWRO8zsNIQLklE.jpg',
                'name' => 'ငါးသားလုံးတုံယမ်း',
                'actual_price' => 8000,
                'primary_unit_id' => 1,
                'primary_price' => 11000,
                'promotion_id' => NULL,
                'stock' => 15.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-20 04:01:01',
                'updated_at' => '2024-10-17 03:26:38'
            ],
            [
                'id' => 14,
                'image' => NULL,
                'name' => 'ငါးခြောက်ထောင်း',
                'actual_price' => 15000,
                'primary_unit_id' => 1,
                'primary_price' => 15000,
                'promotion_id' => NULL,
                'stock' => 0.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-27 04:33:15',
                'updated_at' => '2025-01-09 11:53:49'
            ],
            [
                'id' => 15,
                'image' => NULL,
                'name' => 'ပဲတီချဉ်',
                'actual_price' => 1000,
                'primary_unit_id' => 1,
                'primary_price' => 1000,
                'promotion_id' => NULL,
                'stock' => 4.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-09-27 13:36:04',
                'updated_at' => '2025-01-09 10:10:24'
            ],
            [
                'id' => 16,
                'image' => 'images/cFZH5TY9L0yN3DuwDXXo3N998wY8ahIivaPPqSHp.jpg',
                'name' => 'ငါးခူကြော်နှပ်',
                'actual_price' => 15000,
                'primary_unit_id' => 1,
                'primary_price' => 15000,
                'promotion_id' => NULL,
                'stock' => 2.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-10-04 03:56:28',
                'updated_at' => '2024-10-05 15:28:12'
            ],
            [
                'id' => 17,
                'image' => 'images/hhwREDW20ChhLC11Z5lGI4tEEWwMvkNzoamLBHvr.jpg',
                'name' => 'ဘဲဥသီးစုံဟင်း',
                'actual_price' => 5000,
                'primary_unit_id' => 1,
                'primary_price' => 7000,
                'promotion_id' => NULL,
                'stock' => 11.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-10-16 03:32:54',
                'updated_at' => '2024-10-17 15:54:00'
            ],
            [
                'id' => 18,
                'image' => 'images/tlr8SjZTFKAYtYcRBoCfmZ4og7WPPovruhMfJ5ME.jpg',
                'name' => 'ဝက်သားနီချက်',
                'actual_price' => 10000,
                'primary_unit_id' => 1,
                'primary_price' => 15000,
                'promotion_id' => NULL,
                'stock' => 6.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-10-16 03:36:48',
                'updated_at' => '2024-12-11 04:50:15'
            ],
            [
                'id' => 19,
                'image' => 'images/AJBhGVbsS8U8GiAlmoVowO6n8mtTgcL9kKYnnOyV.jpg',
                'name' => 'ရခိုင်ငပိထောင်း',
                'actual_price' => 1500,
                'primary_unit_id' => 1,
                'primary_price' => 3500,
                'promotion_id' => NULL,
                'stock' => 8.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-10-16 03:37:34',
                'updated_at' => '2024-11-07 15:14:15'
            ],
            [
                'id' => 20,
                'image' => 'images/MbC2OhNrrunomI1PdCbIhfNWGdhATGAOhNPu2wGX.jpg',
                'name' => 'ငါးခေါင်းငပိချက်',
                'actual_price' => 4000,
                'primary_unit_id' => 1,
                'primary_price' => 8000,
                'promotion_id' => NULL,
                'stock' => 5.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-12-04 10:17:48',
                'updated_at' => '2024-12-05 14:03:54'
            ],
            [
                'id' => 21,
                'image' => 'images/SJi1R5TTN3Km8QUU5R8RuLcarj2zS57eJgJrn7FS.jpg',
                'name' => 'ကရင်ငပိချက်',
                'actual_price' => 6000,
                'primary_unit_id' => 1,
                'primary_price' => 10000,
                'promotion_id' => NULL,
                'stock' => 4.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-12-18 04:44:13',
                'updated_at' => '2025-01-09 11:53:49'
            ],
            [
                'id' => 22,
                'image' => 'images/4RgTtONgxugljfreSD2AZOTdkdaALHgx6EXSHCZR.jpg',
                'name' => 'ပါကင်ထုတ်ခ',
                'actual_price' => 1500,
                'primary_unit_id' => 1,
                'primary_price' => 1500,
                'promotion_id' => NULL,
                'stock' => 99932.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-12-18 08:23:16',
                'updated_at' => '2025-01-09 11:10:15'
            ],
            [
                'id' => 24,
                'image' => 'images/7oQUsxU76OoNnKLFi7YTz1QyrQmuTRWK2mqXtAoQ.jpg',
                'name' => 'ရေဦးပဲငပိ',
                'actual_price' => 2500,
                'primary_unit_id' => 5,
                'primary_price' => 5000,
                'promotion_id' => NULL,
                'stock' => 0.00,
                'user_id' => 1,
                'remark' => NULL,
                'created_at' => '2024-12-18 09:00:08',
                'updated_at' => '2025-01-08 14:09:55'
            ]
        ];

       // Insert products
       foreach (array_chunk($products, 50) as $chunk) {
        DB::table('products')->insert($chunk);
    }

} finally {
    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
}
    }
}