<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'nama' => 'Laptop Bekas',
            'deskripsi' => 'Laptop bekas yang masih bagus',
            'harga' => 2500000,
            'stok' => 10,
            'category_id' => 1,
            'image' => 'laptop_bekas.jpg',
        ]);

        DB::table('products')->insert([
            'nama' => 'Kaos Santai',
            'deskripsi' => 'Kaos nyaman untuk santai',
            'harga' => 100000,
            'stok' => 20,
            'category_id' => 2,
            'image' => 'kaos_santai.jpg',
        ]);
    }
}
