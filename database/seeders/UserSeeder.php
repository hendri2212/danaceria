<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database with initial users.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Hendri Arifin',
                'email' => 'cowok_cool320@yahoo.co.id',
                'password' => 'password',
            ],
            [
                'name' => 'Elfia Mutiara Hazna Arifin',
                'email' => 'mutiara.hazna.arifin@gmail.com',
                'password' => 'password',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
