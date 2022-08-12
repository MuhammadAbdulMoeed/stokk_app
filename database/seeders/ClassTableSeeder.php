<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ClassModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ClassModel::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



        $classes = [
            ['name' => 'Lux', 'icon' => 'admin/default_class_images/Lux.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],
            ['name' => 'Van', 'icon' => 'admin/default_class_images/Van.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],
            ['name' => 'Sports', 'icon' => 'admin/default_class_images/Sports.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],
            ['name' => 'Economic', 'icon' => 'admin/default_class_images/Economic.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],
            ['name' => 'Electric', 'icon' => 'admin/default_class_images/Electric.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],

        ];

        foreach ($classes as $class) {
            ClassModel::create($class);
        }

    }
}
