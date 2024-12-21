<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\BaseEnum;

enum TicketPriorityEnum: string
{
    use BaseEnum;
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';

    public function getLabel(): string
    {
        return match ($this) {
            self::LOW => 'کم',
            self::NORMAL => 'متوسط',
            self::HIGH => 'زیاد',
        };
    }

    public static function getArray(): array
    {
        return [
            self::LOW->value,
            self::NORMAL->value,
            self::HIGH->value,
        ];
    }
}
