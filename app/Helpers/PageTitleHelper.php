<?php

namespace App\Helpers;

class PageTitleHelper
{
    public static function title($title = null)
    {
        if (empty($title)) {
            return config('app.name');
        }

        return $title . ' | ' . config('app.name');
    }
}
