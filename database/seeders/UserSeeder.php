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
            ['email' => 'lucas@souza.com'],
            [
                'name' => 'Lucas',
                'password' => Hash::make('123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'webmaster@dev.com'],
            [
                'name' => 'WebMaster',
                'password' => Hash::make('admin'),
            ]
        );
    }
}