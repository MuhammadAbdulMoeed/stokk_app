<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subCategories = [
            ['name' => 'Apartment', 'icon' => 'upload/category/1648462002-Dog House.png',
                'image' => 'upload/category/1648811509-pexels-clayton-bunn-5524167 1.png', 'slug' => 'APARTMENT',
                'is_active' => 1, 'parent_id' => Category::where('name','Property')->first()->id],
            ['name' => 'Vilas', 'icon' => 'upload/category/1648462087-School House.png',
                'image' => null, 'slug' => 'VILAS',
                'is_active' => 1, 'parent_id' => Category::where('name','Property')->first()->id],
            ['name' => 'Houses', 'icon' => 'upload/category/1648462110-House With a Garden.png',
                'image' => null, 'slug' => 'HOUSES',
                'is_active' => 1, 'parent_id' => Category::where('name','Property')->first()->id],
            ['name' => 'Properties', 'icon' => 'upload/category/1648462178-Property.png',
                'image' => null, 'slug' => 'PROPERTIES',
                'is_active' => 1, 'parent_id' => Category::where('name','Property')->first()->id],

            ['name' => 'Car', 'icon' => 'upload/category/1649048404-Sedan.png',
                'image' => null, 'slug' => 'CAR',
                'is_active' => 1, 'parent_id' => Category::where('name','Vehicles')->first()->id],

            ['name' => 'T-Shirts', 'icon' => null,
                'image' => 'upload/category/1649151789-pexels-marcelo-chagas-3324443 1.png', 'slug' => 'T_SHIRTS',
                'is_active' => 1, 'parent_id' => Category::where('name','Fashion')->first()->id],
            ['name' => 'Shirts', 'icon' => null,
                'image' => 'upload/category/1649151811-pexels-lucas-queiroz-1852382 1.png', 'slug' => 'SHIRTS',
                'is_active' => 1, 'parent_id' => Category::where('name','Fashion')->first()->id],
            ['name' => 'Track Suit', 'icon' => null,
                'image' => 'upload/category/1649151842-pexels-godisable-jacob-965324 1.png', 'slug' => 'TRACK_SUIT',
                'is_active' => 1, 'parent_id' => Category::where('name','Fashion')->first()->id],
            ['name' => 'Pent Shirts', 'icon' => null,
                'image' => 'upload/category/1649151864-pexels-marcelo-chagas-2229490 1.png', 'slug' => 'PENT_SHIRTS',
                'is_active' => 1, 'parent_id' => Category::where('name','Fashion')->first()->id],

        ];


        foreach($subCategories as $subCategory)
        {
            Category::create($subCategory);
        }

    }
}
