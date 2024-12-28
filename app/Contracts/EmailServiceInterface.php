<?php

namespace App\Contracts;

interface EmailServiceInterface
{
    public function send(string $to, string $subject, string $content, array $attachments = []): bool;
    public function sendTemplate(string $to, string $template, array $data, string $subject): bool;
}
