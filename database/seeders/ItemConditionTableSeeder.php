<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ItemCondition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ItemCondition::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $conditions = [
            ['name' => 'Unworn', 'category_id' => Category::where('name', 'Fashion')->first()->id, 'is_active' => 1],
            ['name' => 'As good as new', 'category_id' => Category::where('name', 'Fashion')->first()->id, 'is_active' => 1],
            ['name' => 'Good Condition', 'category_id' => Category::where('name', 'Fashion')->first()->id, 'is_active' => 1],
            ['name' => 'Pair Condition', 'category_id' => Category::where('name', 'Fashion')->first()->id, 'is_active' => 1],
            ['name' => 'Has given it all', 'category_id' => Category::where('name', 'Fashion')->first()->id, 'is_active' => 1],
        ];

        foreach ($conditions as $condition)
        {
            ItemCondition::create($condition);
        }


    }
}
