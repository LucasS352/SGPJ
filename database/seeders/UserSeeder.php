<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'lucas@example.com'],
            [
                'name' => 'Lucas',
                'password' => Hash::make('123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'webmaster@example.com'],
            [
                'name' => 'WebMaster',
                'password' => Hash::make('admin'),
            ]
        );
    }
}