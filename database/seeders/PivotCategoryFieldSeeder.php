<?php

namespace Database\Seeders;

use App\Models\PivotCategoryField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PivotCategoryFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PivotCategoryField::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::statement(
            DB::raw("
            INSERT INTO `pivot_categories_fields` (`id`, `category_id`, `sub_category_id`, `custom_field_id`, `order`, `created_at`, `updated_at`) VALUES
(10, 1, 7, 1, NULL, '2022-05-20 01:24:39', '2022-05-20 01:24:39'),
(11, 1, 7, 2, NULL, '2022-05-20 01:24:39', '2022-05-20 01:24:39'),
(12, 1, 7, 3, NULL, '2022-05-20 01:24:39', '2022-05-20 01:24:39'),
(13, 1, 7, 4, NULL, '2022-05-20 01:24:39', '2022-05-20 01:24:39'),
(14, 2, 9, 9, NULL, '2022-05-20 01:24:49', '2022-05-20 01:24:49'),
(15, 2, 9, 10, NULL, '2022-05-20 01:24:49', '2022-05-20 01:24:49'),
(16, 2, 9, 11, NULL, '2022-05-20 01:24:49', '2022-05-20 01:24:49'),
(33, 4, 10, 9, NULL, '2022-05-23 06:22:22', '2022-05-23 06:22:22'),
(34, 4, 10, 12, NULL, '2022-05-23 06:22:22', '2022-05-23 06:22:22'),
(35, 4, 10, 13, NULL, '2022-05-23 06:22:22', '2022-05-23 06:22:22'),
(36, 4, 10, 14, NULL, '2022-05-23 06:22:22', '2022-05-23 06:22:22'),
(37, 4, 10, 15, NULL, '2022-05-23 06:22:22', '2022-05-23 06:22:22'),
(38, 4, 10, 16, NULL, '2022-05-23 06:22:22', '2022-05-23 06:22:22'),
(39, 4, 10, 17, NULL, '2022-05-23 06:22:22', '2022-05-23 06:22:22'),
(40, 4, 10, 18, NULL, '2022-05-23 06:22:22', '2022-05-23 06:22:22');

            "));

    }
}
