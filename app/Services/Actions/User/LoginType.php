<?php

declare(strict_types=1);

namespace App\Services\Actions\User;

use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LoginType
{
    public static function handle($input): string
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        $input = preg_replace('/[^0-9]/', '', $input);

        if (substr($input, 0, 1) === '0') {
            $input = substr($input, 1);
        }

        if (substr($input, 0, 2) === '98') {
            $input = substr($input, 2);
        }

        return 'mobile';
    }
}
