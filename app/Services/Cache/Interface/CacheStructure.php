<?php

namespace App\Services\Cache\Interface;

interface CacheStructure
{
    public static function handle($callback);

    public function remember($remember);

    public function key($key);

    public function get();
}
