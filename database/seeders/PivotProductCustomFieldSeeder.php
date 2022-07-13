<?php

namespace Database\Seeders;

use App\Models\PivotProductCustomField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PivotProductCustomFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PivotProductCustomField::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::statement(
            DB::raw("
INSERT INTO `pivot_products_custom_fields` (`id`, `product_id`, `custom_field_id`, `value`, `created_at`, `updated_at`) VALUES
(202, 19, 9, '5', '2022-07-01 14:28:38', '2022-07-01 14:28:38'),
(203, 19, 14, 'Full', '2022-07-01 14:28:38', '2022-07-01 14:28:38'),
(204, 19, 15, 'Black', '2022-07-01 14:28:38', '2022-07-01 14:28:38'),
(205, 19, 12, 'Cotton', '2022-07-01 14:28:38', '2022-07-01 14:28:38'),
(206, 19, 13, 'Simple', '2022-07-01 14:28:38', '2022-07-01 14:28:38'),
(207, 19, 16, '3', '2022-07-01 14:28:38', '2022-07-01 14:28:38'),
(208, 19, 17, '1', '2022-07-01 14:28:38', '2022-07-01 14:28:38'),
(209, 19, 18, '1', '2022-07-01 14:28:38', '2022-07-01 14:28:38'),
(210, 20, 9, '7', '2022-07-04 17:16:49', '2022-07-04 17:16:49'),
(211, 20, 12, 'Normal', '2022-07-04 17:16:49', '2022-07-04 17:16:49'),
(212, 20, 13, 'Simple', '2022-07-04 17:16:49', '2022-07-04 17:16:49'),
(213, 20, 14, '12 inch', '2022-07-04 17:16:49', '2022-07-04 17:16:49'),
(214, 20, 15, 'Black & White', '2022-07-04 17:16:49', '2022-07-04 17:16:49'),
(215, 20, 16, '3', '2022-07-04 17:16:49', '2022-07-04 17:16:49'),
(216, 20, 17, '7', '2022-07-04 17:16:49', '2022-07-04 17:16:49'),
(217, 20, 18, '2', '2022-07-04 17:16:49', '2022-07-04 17:16:49');
            "));
    }
}
