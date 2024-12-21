<?php

declare(strict_types=1);

namespace App\Services\Cache;


use Coderflex\LaravelTicket\Models\Label;

class LabelCache
{
    public static function all($remember)
    {
        return UseCacheRemember::handle(function () {
            return Label::all();
        })->remember($remember)
            ->key('Label:all')
            ->get();
    }
    public static function allActive($remember)
    {
        return UseCacheRemember::handle(function () {
            return Label::where('is_visible', true)->get();
        })->remember($remember)
            ->key('Label:allActive')
            ->get();
    }
}
