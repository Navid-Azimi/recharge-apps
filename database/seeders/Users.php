<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            [
                'name'     => 'Admin',
                'email'    => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'user_role' => 'admin',
                'email_verified_at' => '2023-11-16 07:13:51',
            ],
            [
                'name'     => 'Demo Reseller',
                'email'    => 'reseller@gmail.com',
                'password' => bcrypt('reseller'),
                'user_role' => 'reseller',
                'email_verified_at' => '2023-11-16 07:13:51',
            ],
            [
                'name'     => 'Demo Customer',
                'email'    => 'customer@gmail.com',
                'password' => bcrypt('customer'),
                'user_role' => 'customer',
                'email_verified_at' => '2023-11-16 07:13:51',
            ]
        );

        User::insert($data);
    }
}
