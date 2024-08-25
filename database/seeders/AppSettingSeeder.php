<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        AppSetting::create([
            'name' => 'Galaxy Food And Drink',
            'phone' => '0943113458',
            'email' => 'contact.galaxyfoodanddrink@gmail.com',
            'address' => 'Hay Mar Ga Naing Street',
            'google_map_url' => 'https://maps.google.com/example',
            'user_id' => 1,
            // 'logo' => "https://i.postimg.cc/FzL0bSm3/pngtree-building-and-construction-logo-design-template-image-317780.jpg"
        ]);
    }
}
