<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $brands = [
            ['name' => 'Audi', 'icon' => 'admin/default_brand_images/Audi.png', 'is_active' => 1,
                'parent_category_id' => Category::where('name','Vehicles')->first()->id,
                'category_id' => Category::where('name', 'Car')->first()->id],
            ['name' => 'Mercedes', 'icon' => 'admin/default_brand_images/Mercedes.png', 'is_active' => 1,
                'parent_category_id' => Category::where('name','Vehicles')->first()->id,
                'category_id' => Category::where('name', 'Car')->first()->id],
            ['name' => 'BMW', 'icon' => 'admin/default_brand_images/BMW.png', 'is_active' => 1,
                'parent_category_id' => Category::where('name','Vehicles')->first()->id,
                'category_id' => Category::where('name', 'Car')->first()->id],
            ['name' => 'FIAT', 'icon' => 'admin/default_brand_images/FIAT.png', 'is_active' => 1,
                'parent_category_id' => Category::where('name','Vehicles')->first()->id,
                'category_id' => Category::where('name', 'Car')->first()->id],

            ['name' => 'Zara', 'icon' => null, 'is_active' => 1,
                'parent_category_id' => Category::where('name', 'Fashion')->first()->id],
            ['name' => 'Nike', 'icon' => null, 'is_active' => 1,
                'parent_category_id' => Category::where('name', 'Fashion')->first()->id],
            ['name' => 'Addidas', 'icon' => null, 'is_active' => 1,
                'parent_category_id' => Category::where('name', 'Fashion')->first()->id],

        ];

        foreach($brands as $brand)
        {
            Brand::create($brand);
        }
    }
}
