<?php

namespace Database\Seeders;

use Coderflex\LaravelTicket\Models\Label;
use Illuminate\Database\Seeder;
use Coderflex\LaravelTicket\Models\Category;

class TicketTablesSeeder extends Seeder
{
    public function run()
    {
        // دسته‌بندی‌ها
        $categories = [
            'پشتیبانی فنی',
            'مالی',
            'عمومی',
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category], ['name' => $category, 'slug' => '']);
        }

        // برچست ها
        $labels = [
            'مهاجرت',
            'خدمات',
            'بیزینس',
        ];

        foreach ($labels as $label) {
            Label::updateOrCreate(['name' => $label], ['name' => $label, 'slug' => '']);
        }
    }
}
