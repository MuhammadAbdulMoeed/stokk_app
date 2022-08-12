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
            ['name' => 'Property', 'parent_id' => null, 'icon' => 'admin/default_category_images/Property.png',
                'image' => null, 'slug' => 'PROPERTY', 'is_active' => 1],

            ['name' => 'Vehicles', 'parent_id' => null, 'icon' => 'admin/default_category_images/Vehicles.png',
                'image' => null, 'slug' => 'VEHICLES', 'is_active' => 1],

            ['name' => 'Bike', 'parent_id' => null, 'icon' => 'admin/default_category_images/Bike.png',
                'image' => null, 'slug' => 'BIKE', 'is_active' => 0],

            ['name' => 'Fashion', 'parent_id' => null, 'icon' => 'admin/default_category_images/Fashion.png',
                'image' => null, 'slug' => 'FASHION', 'is_active' => 1],

        ];


        foreach ($categories as $category) {
            Category::create($category);
        }

    }
}
