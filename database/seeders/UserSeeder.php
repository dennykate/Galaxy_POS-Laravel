<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->truncate();

        $users = [
            [
                'id' => 1,
                'name' => 'Thwe Thwe',
                'email' => 'smith.eleanore@example.org',
                'phone' => '09955099985',
                'address' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Soluta fugit impedit magnam eos dicta nesciunt rem facilis laudantium alias minima dolorem consequuntur hic explicabo, ipsam at? Deserunt perspiciatis pariatur accusantium!',
                'position' => 'မန်နေဂျာ',
                'role' => 'admin',
                'gender' => 'ကျား',
                'salary' => 3000000,
                'birth_date' => '2024-09-06 17:00:00',
                'join_date' => '2024-09-06 17:00:00',
                'email_verified_at' => '2024-09-06 17:03:44',
                'password' => '$2y$12$Br5V7LmjKmbH.SEtHoWfpuSVpuWIaK8EpyZIO4TEba2GEhLHl1xti',
                'profile' => NULL,
                'remember_token' => 'TirR5AFkUT',
                'created_at' => '2024-09-06 17:03:44',
                'updated_at' => '2024-09-06 17:03:44'
            ],
            [
                'id' => 2,
                'name' => 'A Tar Oo',
                'email' => NULL,
                'phone' => '0987654321',
                'address' => NULL,
                'position' => NULL,
                'role' => 'staff',
                'gender' => 'ကျား',
                'salary' => NULL,
                'birth_date' => NULL,
                'join_date' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$q27/cPlltjAX/lWGPQh09eEEIh/CXfpnM2eeNage95huJ7j.gaSEK',
                'profile' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-09-12 08:28:29',
                'updated_at' => '2024-09-12 08:28:29'
            ],
            [
                'id' => 5,
                'name' => 'Phoenix',
                'email' => NULL,
                'phone' => '09988776543',
                'address' => NULL,
                'position' => NULL,
                'role' => 'staff',
                'gender' => 'ကျား',
                'salary' => NULL,
                'birth_date' => NULL,
                'join_date' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$pkRIU9r.laZNCCsYQfIoxeDREM5b73DM9qTk0HM3IKsn.9H1neIqO',
                'profile' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-09-12 09:01:32',
                'updated_at' => '2024-09-12 09:01:32'
            ],
            [
                'id' => 7,
                'name' => 'Phoenixx',
                'email' => NULL,
                'phone' => '09988776543',
                'address' => NULL,
                'position' => NULL,
                'role' => 'staff',
                'gender' => 'ကျား',
                'salary' => NULL,
                'birth_date' => NULL,
                'join_date' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$LE9tToqNRcqkTdOU9Vm5aOAPtZabod57H/NdiQYIuxDXBoz.11.jG',
                'profile' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-09-12 09:02:31',
                'updated_at' => '2024-09-12 09:02:31'
            ],
            [
                'id' => 8,
                'name' => 'Aung Aung',
                'email' => NULL,
                'phone' => '09122131232',
                'address' => NULL,
                'position' => NULL,
                'role' => 'staff',
                'gender' => 'ကျား',
                'salary' => NULL,
                'birth_date' => NULL,
                'join_date' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$12$t2hwD97Q8ub/1b3P2nnvnOka66dnDzFJ0/oyD1.Xuj0aAIEFfk3Cy',
                'profile' => NULL,
                'remember_token' => NULL,
                'created_at' => '2024-10-14 11:36:21',
                'updated_at' => '2024-10-14 11:36:21'
            ]
        ];

        foreach (array_chunk($users, 50) as $chunk) {
            DB::table('users')->insert($chunk);
        }
    }
}