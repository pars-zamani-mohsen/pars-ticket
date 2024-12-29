<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\BaseEnum;

enum TicketStatusEnum: string
{
    use BaseEnum;

    case OPEN = 'open';
    case CLOSE = 'closed';
    case ARCHIVED = 'archived';


    public function getLabel(): string
    {
        return match ($this) {
            self::OPEN => __('ticket.open'),
            self::CLOSE => __('ticket.close'),
            self::ARCHIVED => __('ticket.archived'),
        };
    }

    public static function getArray(): array
    {
        return [
            self::OPEN->value,
            self::CLOSE->value,
            self::ARCHIVED->value,
        ];
    }
}
