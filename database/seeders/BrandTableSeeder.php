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
            ['name' => 'Audi', 'icon' => 'upload/brand/1649050307-R (1) 1.png', 'is_active' => 1,
                'category_id' => Category::where('name', 'Car')->first()->id],
            ['name' => 'Mercedes', 'icon' => 'upload/brand/1649053021-mercedes-benz-logo-png-mercedes-star-logo-11563004766vedth4alte 2.png', 'is_active' => 1,
                'category_id' => Category::where('name', 'Car')->first()->id],
            ['name' => 'BMW', 'icon' => 'upload/category/1649053215-R (2) 2.png', 'is_active' => 1,
                'category_id' => Category::where('name', 'Car')->first()->id],
            ['name' => 'FIAT', 'icon' => 'upload/category/1649053308-R (3) 2.png', 'is_active' => 1,
                'category_id' => Category::where('name', 'Car')->first()->id],

            ['name' => 'Zara', 'icon' => null, 'is_active' => 1,
                'category_id' => Category::where('name', 'Fashion')->first()->id],
            ['name' => 'Nike', 'icon' => null, 'is_active' => 1,
                'category_id' => Category::where('name', 'Fashion')->first()->id],
            ['name' => 'Addidas', 'icon' => null, 'is_active' => 1,
                'category_id' => Category::where('name', 'Fashion')->first()->id],

        ];

        foreach($brands as $brand)
        {
            Brand::create($brand);
        }
    }
}
