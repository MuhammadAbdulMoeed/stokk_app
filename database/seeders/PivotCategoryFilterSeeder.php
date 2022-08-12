<?php

namespace Database\Seeders;

use App\Models\PivotCategoryFilter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PivotCategoryFilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PivotCategoryFilter::truncate();

        DB::statement(
            DB::raw("
INSERT INTO `pivot_category_filters` (`id`, `category_id`, `filter_id`, `order`, `created_at`, `updated_at`) VALUES
(4, 4, 9, NULL, '2022-05-23 06:27:21', '2022-05-23 06:27:21'),
(5, 4, 18, NULL, '2022-05-23 06:27:21', '2022-05-23 06:27:21'),
(6, 2, 9, NULL, '2022-05-23 07:24:21', '2022-05-23 07:24:21'),
(7, 2, 10, NULL, '2022-05-23 07:24:21', '2022-05-23 07:24:21'),
(8, 2, 11, NULL, '2022-05-23 07:24:21', '2022-05-23 07:24:21'),
(9, 1, 1, NULL, '2022-05-24 02:05:59', '2022-05-24 02:05:59'),
(10, 1, 2, NULL, '2022-05-24 02:05:59', '2022-05-24 02:05:59'),
(11, 1, 3, NULL, '2022-05-24 02:05:59', '2022-05-24 02:05:59'),
(12, 1, 4, NULL, '2022-05-24 02:05:59', '2022-05-24 02:05:59');

            "));

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
