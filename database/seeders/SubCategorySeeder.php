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
            ['name' => 'Apartment', 'icon' => 'admin/default_category_images/Apartment.png',
                'image' => 'admin/default_category_images/Apartment-Image.png', 'slug' => 'APARTMENT',
                'is_active' => 1, 'parent_id' => Category::where('name','Property')->first()->id],
            ['name' => 'Vilas', 'icon' => 'admin/default_category_images/Vilas.png',
                'image' => 'admin/default_category_images/Vilas-Image.png', 'slug' => 'VILAS',
                'is_active' => 1, 'parent_id' => Category::where('name','Property')->first()->id],
            ['name' => 'Houses', 'icon' => 'admin/default_category_images/House.png',
                'image' => 'admin/default_category_images/Houses-Image.png', 'slug' => 'HOUSES',
                'is_active' => 1, 'parent_id' => Category::where('name','Property')->first()->id],
            ['name' => 'Properties', 'icon' => 'admin/default_category_images/Property.png',
                'image' => 'admin/default_category_images/Property-Image.png', 'slug' => 'PROPERTIES',
                'is_active' => 1, 'parent_id' => Category::where('name','Property')->first()->id],

            ['name' => 'Car', 'icon' => 'admin/default_category_images/Car.png',
                'image' => null, 'slug' => 'CAR',
                'is_active' => 1, 'parent_id' => Category::where('name','Vehicles')->first()->id],

            ['name' => 'T-Shirts', 'icon' => null,
                'image' => 'admin/default_category_images/T-Shirts.png', 'slug' => 'T_SHIRTS',
                'is_active' => 1, 'parent_id' => Category::where('name','Fashion')->first()->id],
            ['name' => 'Shirts', 'icon' => null,
                'image' => 'admin/default_category_images/Shirts.png', 'slug' => 'SHIRTS',
                'is_active' => 1, 'parent_id' => Category::where('name','Fashion')->first()->id],
            ['name' => 'Track Suit', 'icon' => null,
                'image' => 'admin/default_category_images/Track-Suit.png', 'slug' => 'TRACK_SUIT',
                'is_active' => 1, 'parent_id' => Category::where('name','Fashion')->first()->id],
            ['name' => 'Pent Shirts', 'icon' => null,
                'image' => 'admin/default_category_images/Pent-Shirts.png', 'slug' => 'PENT_SHIRTS',
                'is_active' => 1, 'parent_id' => Category::where('name','Fashion')->first()->id],

        ];


        foreach($subCategories as $subCategory)
        {
            Category::create($subCategory);
        }

    }
}
