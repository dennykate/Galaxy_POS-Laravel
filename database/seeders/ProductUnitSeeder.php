<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductUnitSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_units')->truncate();

        $productUnits = [
            [
                'product_id' => 4,
                'unit_id' => 10,
                'price' => 14000,
                'is_default' => 1
            ]
        ];

        DB::table('product_units')->insert($productUnits);
    }
}