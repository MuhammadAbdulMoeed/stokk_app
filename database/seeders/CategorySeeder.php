<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $categories = [
            ['name' => 'Real Estate', 'parent_id' => null, 'icon' => 'upload/category/1648461739-Dog House.png',
                'image' => null, 'slug' => 'REAL_ESTATE', 'is_active' => 1],

            ['name' => 'Vehicles', 'parent_id' => null, 'icon' => 'upload/category/1648461639-Sedan.png',
                'image' => null, 'slug' => 'VEHICLES', 'is_active' => 1],

            ['name' => 'Bike', 'parent_id' => null, 'icon' => 'upload/category/1648461758-Quad Bike.png',
                'image' => null, 'slug' => 'BIKE', 'is_active' => 1],

            ['name' => 'Fashion', 'parent_id' => null, 'icon' => 'upload/category/1648461789-Clothes.png',
                'image' => null, 'slug' => 'FASHION', 'is_active' => 1],

        ];


        foreach ($categories as $category) {
            Category::create($category);
        }

    }
}
