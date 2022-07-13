<?php

namespace Database\Seeders;

use App\Models\CustomFieldOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomFieldOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CustomFieldOption::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::statement(
            DB::raw("
            INSERT INTO `custom_field_options` (`id`, `name`, `custom_field_id`, `created_at`, `updated_at`) VALUES
            (1, 'For Rent', 5, '2022-05-16 02:05:04', '2022-05-16 02:05:04'),
            (2, 'For Sale', 5, '2022-05-16 02:05:04', '2022-05-16 02:05:04'),
            (3, 'Male', 16, '2022-05-23 01:14:33', '2022-05-23 01:14:33'),
            (4, 'Female', 16, '2022-05-23 01:14:33', '2022-05-23 01:14:33');
       "));
    }
}
