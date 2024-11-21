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
               'name'=>'User',
               'email'=>'user@mail.com',
               'type'=>0,
               'password'=> bcrypt('user123'),
            ],
            [
               'name'=>'Admin',
               'email'=>'admin@mail.com',
               'type'=>1,
               'password'=> bcrypt('admin123'),
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
