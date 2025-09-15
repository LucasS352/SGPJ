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
            ['email' => 'rafael@sgpj.com'],
            [
                'name' => 'Rafael',
                'password' => Hash::make('rafael123'),
            ]
        );
        {
        User::updateOrCreate(
            ['email' => 'bruno@sgpj.com'],
            [
                'name' => 'Bruno',
                'password' => Hash::make('bruno123'),
            ]
        );

        {
        User::updateOrCreate(
            ['email' => 'renan@sgpj.com'],
            [
                'name' => 'Lucas',
                'password' => Hash::make('renan123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'teltech@sgpj.com'],
            [
                'name' => 'WebMaster',
                'password' => Hash::make('admin123'),
            ]
        );
    } }
}
}