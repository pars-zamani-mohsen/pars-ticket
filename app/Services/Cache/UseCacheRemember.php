<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Services\Cache\Interface\CacheStructure;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

class UseCacheRemember implements CacheStructure
{
    protected $callback;

    protected int $remember;

    protected string $key;

    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    public static function handle($callback): UseCacheRemember
    {
        return new self($callback);
    }

    public function remember($remember)
    {
        $this->remember = $remember;

        return $this;
    }

    public function key($key)
    {
        $this->key = $key;

        return $this;
    }

    public function get()
    {
        $remember = $this->remember ?? config('custom.cache.timeout-short');

        if (! $this->key) {
            throw new RuntimeException('you must define a key, please use the key function an pass on it');
        }

        $cachedData = Cache::remember($this->key, $remember, function () {
            return serialize(($this->callback)());
        });

        return unserialize($cachedData);
    }
}
