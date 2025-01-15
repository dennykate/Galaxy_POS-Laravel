<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run()
    {
         // Disable foreign key checks before truncating
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');

         try {
             // Truncate the tables in the correct order
             DB::table('product_units')->truncate(); // First truncate the referencing table
             DB::table('units')->truncate();         // Then truncate the referenced table        // Then truncate the referenced table

        $units = [
            [
                'id' => 1,
                'name' => 'ခု',
                'unit_type_id' => 3,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 2,
                'name' => 'ချောင်း',
                'unit_type_id' => 3,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 3,
                'name' => 'အိတ်',
                'unit_type_id' => 3,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 4,
                'name' => 'ကျပ်သား',
                'unit_type_id' => 1,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 5,
                'name' => 'ပိဿာ',
                'unit_type_id' => 1,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 6,
                'name' => 'ပေ',
                'unit_type_id' => 2,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 7,
                'name' => 'လက်မ',
                'unit_type_id' => 2,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 8,
                'name' => 'ကိုက်',
                'unit_type_id' => 2,
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 9,
                'name' => 'ကောင်',
                'unit_type_id' => 3,
                'created_at' => '2024-10-25 01:36:52',
                'updated_at' => '2024-10-25 01:36:52'
            ],
            [
                'id' => 10,
                'name' => 'ခြမ်း',
                'unit_type_id' => 3,
                'created_at' => '2024-10-25 01:37:08',
                'updated_at' => '2024-10-25 01:37:08'
            ]
        ];

        DB::table('units')->insert($units);

    } finally {
        // Re-enable foreign key checks after seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    }
}