<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\BaseEnum;

enum TicketVisibilityEnum: int
{
    use BaseEnum;
    case VISIBLE = 1;
    case HIDDEN = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::VISIBLE => 'فعال',
            self::HIDDEN => 'غیرفعال',
        };
    }

    public static function getArray(): array
    {
        return [
            self::VISIBLE->value,
            self::HIDDEN->value,
        ];
    }
}
