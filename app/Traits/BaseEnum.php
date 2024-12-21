<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait BaseEnum
{
    public static function getSelectBoxTransformItems(): Collection
    {
        return collect(self::cases())
            ->map(function ($item) {
                return ['key' => $item->getLabel(), 'value' => $item->value];
            });
    }

    public static function getWithLabel(): Collection
    {
        return collect(self::cases())
            ->map(function ($item) {
                return ['label' => $item->getLabel(), 'value' => $item->value, 'name' => $item->name];
            });
    }

    public static function getWithLabelObject(): Collection
    {
        return collect(self::cases())
            ->map(function ($item) {
                return (object) ['label' => $item->getLabel(), 'value' => $item->value, 'name' => $item->name];
            });
    }

    public static function getAllValues(): Collection
    {
        return collect(self::cases())->pluck('value');
    }

    public static function getAllLabels(): Collection
    {
        return collect(self::cases())
            ->map(function ($item) {
                return $item->getLabel();
            });
    }

    public static function getAllNames(): Collection
    {
        return collect(self::cases())->pluck('name');
    }

    public function getLabel(): string
    {
        return __('user.unknown');
    }
}
