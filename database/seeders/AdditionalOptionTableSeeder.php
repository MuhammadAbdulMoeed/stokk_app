<?php

namespace Database\Seeders;

use App\Models\AdditionalOption;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdditionalOptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AdditionalOption::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $options = [
            ['name' => 'Manual', 'category_id' => Category::where('name', 'Vehicles')->first()->id,
                'is_active' => 1],
            ['name' => 'Automatic', 'category_id' => Category::where('name', 'Vehicles')->first()->id,
                'is_active' => 1],
            ['name' => '2 Door', 'category_id' => Category::where('name', 'Vehicles')->first()->id,
                'is_active' => 1],
            ['name' => '4 Door', 'category_id' => Category::where('name', 'Vehicles')->first()->id,
                'is_active' => 1],

        ];

        foreach ($options as $option) {
            AdditionalOption::create($option);
        }

    }
}
