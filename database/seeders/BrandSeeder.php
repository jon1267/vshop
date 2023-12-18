<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Dell', 'slug' => 'dell', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung', 'slug' => 'samsung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Apple', 'slug' => 'apple', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('brands')->insert($brands);
    }
}
