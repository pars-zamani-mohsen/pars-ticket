<?php

namespace App\Contracts;

interface SMSServiceInterface
{
    public function send(string $mobile, string $message): bool;
    public function sendBulk(array $mobiles, string $message): array;
}
