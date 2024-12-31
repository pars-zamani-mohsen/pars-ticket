<?php

namespace App\Services\Notifications;

use App\Contracts\EmailServiceInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class LaravelEmailService implements EmailServiceInterface
{
    public function send(string $to, string $subject, string $content, array $attachments = []): bool
    {
        try {
            Mail::raw($content, function ($message) use ($to, $subject, $attachments) {
                $message->to($to)
                    ->subject($subject);

                foreach ($attachments as $attachment) {
                    $message->attach($attachment);
                }
            });

            Log::info('Email sent successfully', [
                'to' => $to,
                'subject' => $subject
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'to' => $to,
                'subject' => $subject,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function sendTemplate(string $to, string $template, array $data, string $subject): bool
    {
        try {
            Mail::send($template, $data, function ($message) use ($to, $subject) {
                $message->to($to)
                    ->subject($subject);
            });

            Log::info('Template email sent successfully', [
                'to' => $to,
                'template' => $template,
                'subject' => $subject
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Template email sending failed', [
                'to' => $to,
                'template' => $template,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
