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
            'logo' => "https://i.postimg.cc/rFVcWyRn/Lg-T2-S5-POvx54-Ts-N7-Qy2fed8-XXUzi8o-HU1-SSTp-Vs-X.png"
        ]);
    }
}
