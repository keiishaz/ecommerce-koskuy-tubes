<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin 1',
            'username' => 'admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        DB::table('users')->insert([
            'name' => 'Pembeli 1',
            'username' => 'pembeli1',
            'email' => 'pembeli1@gmail.com',
            'password' => Hash::make('pembeli123'),
            'role' => 'pembeli',
        ]);
    }
}
