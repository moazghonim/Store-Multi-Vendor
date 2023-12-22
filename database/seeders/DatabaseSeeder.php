<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(5)->create();
        Store::factory(5)->create();
        Product::factory(100)->create();
        $this->call(UserSeeder::class);
    }
}
