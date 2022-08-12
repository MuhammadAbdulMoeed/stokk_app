<?php

namespace Database\Seeders;

use App\Models\CustomField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CustomField::truncate();

        DB::statement(
            DB::raw("
            INSERT INTO `custom_fields` (`id`, `name`, `field_type`, `slug`, `value_taken_from`, `type`, `order`, `parent_id`, `option_id`, `is_required`, `filter`, `filter_field_type`, `min`, `max`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Bathroom', 'number_field', 'bathroom', NULL, 'custom_field', NULL, NULL, NULL, 1, 1, 'range_slider', '1', '5', 1, '2022-05-16 02:03:27', '2022-05-16 02:03:27'),
(2, 'Land Size', 'number_field', 'land_size', NULL, 'custom_field', NULL, NULL, NULL, 1, 1, 'range_slider', '1', '5', 1, '2022-05-16 02:03:27', '2022-05-16 02:03:27'),
(3, 'Living Room', 'number_field', 'living_room', NULL, 'custom_field', NULL, NULL, NULL, 1, 1, 'range_slider', '1', '5', 1, '2022-05-16 02:03:27', '2022-05-16 02:03:27'),
(4, 'Bed Room', 'number_field', 'bed_room', NULL, 'custom_field', NULL, NULL, NULL, 1, 1, 'range_slider', '1', '5', 1, '2022-05-16 02:03:27', '2022-05-16 02:03:27'),
(5, 'Type', 'simple_select_option', 'type', NULL, 'custom_field', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 0, '2022-05-16 02:05:04', '2022-05-19 05:56:40'),
(6, 'Rent Per Day', 'number_field', 'rent_per_day', NULL, 'custom_field', NULL, 5, 1, 1, 0, NULL, NULL, NULL, 1, '2022-05-16 02:05:47', '2022-05-16 02:05:47'),
(7, 'Rent Per Month', 'number_field', 'rent_per_month', NULL, 'custom_field', NULL, 5, 1, 1, 0, NULL, NULL, NULL, 1, '2022-05-16 02:05:47', '2022-05-16 02:05:47'),
(8, 'Price', 'number_field', 'price', NULL, 'custom_field', NULL, 5, 2, 1, 0, NULL, NULL, NULL, 1, '2022-05-16 02:05:47', '2022-05-16 02:15:58'),
(9, 'Brands', 'simple_select_option', 'brands', 'brands', 'pre_included_field', NULL, NULL, NULL, 1, 1, 'simple_select_option', NULL, NULL, 1, '2022-05-16 02:09:14', '2022-05-16 02:09:14'),
(10, 'Class', 'simple_select_option', 'class', 'classes', 'pre_included_field', NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 1, '2022-05-16 02:09:38', '2022-05-16 02:09:38'),
(11, 'Additional Options', 'multi_select_option', 'additional_options', 'additional_options', 'pre_included_field', NULL, NULL, NULL, 1, 1, 'simple_select_option', NULL, NULL, 1, '2022-05-16 02:09:58', '2022-05-16 02:10:47'),
(12, 'Material', 'input_field', 'material', NULL, 'custom_field', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 1, '2022-05-23 00:53:49', '2022-05-23 00:53:49'),
(13, 'Style', 'input_field', 'style', NULL, 'custom_field', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 1, '2022-05-23 00:54:18', '2022-05-23 00:54:18'),
(14, 'Length', 'input_field', 'length', NULL, 'custom_field', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 1, '2022-05-23 00:55:11', '2022-05-23 00:55:11'),
(15, 'Color', 'input_field', 'color', NULL, 'custom_field', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 1, '2022-05-23 00:55:31', '2022-05-23 00:55:31'),
(16, 'Gender', 'simple_select_option', 'gender', NULL, 'custom_field', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 1, '2022-05-23 01:14:33', '2022-05-23 01:14:33'),
(17, 'Size', 'multi_select_option', 'size', 'sizes', 'pre_included_field', NULL, NULL, NULL, 1, 1, 'simple_select_option', NULL, NULL, 1, '2022-05-23 02:27:47', '2022-05-23 06:19:34'),
(18, 'Item Condition', 'simple_select_option', 'item_condition', 'item_conditions', 'pre_included_field', NULL, NULL, NULL, 1, 1, 'simple_select_option', NULL, NULL, 1, '2022-05-23 06:19:01', '2022-05-23 06:19:28');
    "));


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }


}
