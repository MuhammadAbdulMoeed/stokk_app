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
            ['name' => 'Lux', 'icon' => 'upload/brand/1649055352-Crown.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],
            ['name' => 'Van', 'icon' => 'upload/brand/1649055485-Shuttle bus.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],
            ['name' => 'Sports', 'icon' => 'upload/brand/1649055515-Speedometer.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],
            ['name' => 'Economic', 'icon' => 'upload/brand/1649055545-Expensive.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],
            ['name' => 'Electric', 'icon' => 'upload/brand/1649055567-Lightning Bolt.png',
                'category_id' => Category::where('name', 'Car')->first()->id, 'is_active' => 1],

        ];

        foreach ($classes as $class) {
            ClassModel::create($class);
        }

    }
}
