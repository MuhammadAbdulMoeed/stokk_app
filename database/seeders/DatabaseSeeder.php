<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleTableSeeder::class,
            UserTableSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            ClassTableSeeder::class,
            BrandTableSeeder::class,
            ItemConditionTableSeeder::class,
            AdditionalOptionTableSeeder::class,
            CustomFieldSeeder::class,
            CustomFieldOptionSeeder::class,
            PivotCategoryFieldSeeder::class,
            PivotCategoryFilterSeeder::class,
            PivotProductCustomFieldSeeder::class
        ]);
    }
}
