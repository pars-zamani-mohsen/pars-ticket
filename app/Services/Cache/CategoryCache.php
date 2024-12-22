<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Coderflex\LaravelTicket\Models\Category;

class CategoryCache
{
    public static function all($remember)
    {
        return UseCacheRemember::handle(function () {
            return Category::all();
        })->remember($remember)
            ->key('Category:all')
            ->get();
    }

    public static function allActive($remember)
    {
        return UseCacheRemember::handle(function () {
            return Category::where('is_visible', true)->get();
        })->remember($remember)
            ->key('Category:allActive')
            ->get();
    }
}
