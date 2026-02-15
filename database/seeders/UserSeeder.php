<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin Apotek',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Apoteker Adani',
            'email' => 'apoteker@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'apoteker',
        ]);

        \App\Models\User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'pelanggan@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'pelanggan',
        ]);
    }
}
