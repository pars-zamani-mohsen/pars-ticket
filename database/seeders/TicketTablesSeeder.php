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
            Category::create(['name' => $category, 'slug' => '']);
        }
        // دسته‌بندی‌ها
        $categories = [
            'نام ۱',
            'نام ۲',
            'نام ۳',
        ];

        foreach ($categories as $category) {
            Label::create(['name' => $category, 'slug' => '']);
        }
    }
}
