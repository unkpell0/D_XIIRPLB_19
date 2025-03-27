<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'User',
                'email' => 'user@mail.com',
                'role' => 'user',
                'password' => bcrypt('user123'),
            ],
            [
                'name' => 'Owner',
                'email' => 'owner@mail.com',
                'role' => 'owner',
                'password' => bcrypt('owner123'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'role' => 'admin',
                'password' => bcrypt('admin123'),
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
