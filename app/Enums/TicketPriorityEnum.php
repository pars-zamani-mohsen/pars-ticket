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
            self::LOW => __('ticket.low_value'),
            self::NORMAL => __('ticket.normal'),
            self::HIGH => __('ticket.high_value'),
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
