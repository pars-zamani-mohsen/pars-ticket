<?php

declare(strict_types=1);

namespace App\Services\Actions\Ticket\Notification;

use App\Models\Ticket;
use Morilog\Jalali\Jalalian;

class PerpareNotificationMessageService
{
    public function __construct(public Ticket $ticket)
    {

    }

    private function generateTrackingUrl(): string
    {
        return config('app.url') . '/tickets/' . $this->ticket->id;
    }

    public function ticketCreatedPrepareSMSMessage(): string
    {
        return sprintf(
            "برای شما یک تیکت با شماره %s ثبت شد.\nعنوان: %s\nلینک پیگیری: %s",
            $this->ticket->id,
            $this->ticket->title,
            $this->generateTrackingUrl()
        );
    }

    public function ticketCreatedPrepareEmailContent(): string
    {
        return sprintf(
            "برای شما یک تیکت با مشخصات زیر ثبت شد:\n\n" .
            "شماره تیکت: %s\n" .
            "عنوان: %s\n" .
            "تاریخ ثبت: %s\n\n" .
            "برای پیگیری تیکت خود می‌توانید به لینک زیر مراجعه کنید:\n%s",
            $this->ticket->id,
            $this->ticket->title,
            Jalalian::fromCarbon($this->ticket->created_at)->format('Y/m/d H:i'),
            $this->generateTrackingUrl()
        );
    }

    public function ticketUpdatedPrepareSMSMessage(array $changes): string
    {
        if (in_array('is_resolved', $changes)) {
            $typeMessage = 'در دسته بندی تغییر کرد';
        }

        if (in_array('categories', $changes)) {
            $typeMessage = 'بسته شد';
        }

        return sprintf(
            "تیکت شما با شماره %s %s .\nلینک پیگیری: %s",
            $this->ticket->id,
            $typeMessage,
            $this->generateTrackingUrl()
        );
    }

    public function ticketUpdatedPrepareEmailContent(array $changes): string
    {
        if (in_array('is_resolved', $changes)) {
            $typeMessage = 'در دسته بندی تغییر کرد';
        }

        if (in_array('categories', $changes)) {
            $typeMessage = 'بسته شد';
        }

        return sprintf(
            "تیکت شما با مشخصات زیر %s:\n\n" .
            "شماره تیکت: %s\n" .
            "عنوان: %s\n" .
            "تاریخ ثبت: %s\n\n" .
            "برای پیگیری تیکت خود می‌توانید به لینک زیر مراجعه کنید:\n%s",
            $typeMessage,
            $this->ticket->id,
            $this->ticket->title,
            Jalalian::fromCarbon($this->ticket->created_at)->format('Y/m/d H:i'),
            $this->generateTrackingUrl()
        );
    }


    public function ticketRepliedPrepareSMSMessage(): string
    {
        return sprintf(
            "تیکت شما با شماره %s پاسخ داده شد.\nعنوان: %s\nلینک پیگیری: %s",
            $this->ticket->id,
            $this->ticket->title,
            $this->generateTrackingUrl()
        );
    }

    public function ticketRepliedPrepareEmailContent(): string
    {
        return sprintf(
            "تیکت شما با مشخصات زیر پاسخ داده شد:\n\n" .
            "شماره تیکت: %s\n" .
            "عنوان: %s\n" .
            "تاریخ ثبت: %s\n\n" .
            "برای پیگیری تیکت خود می‌توانید به لینک زیر مراجعه کنید:\n%s",
            $this->ticket->id,
            $this->ticket->title,
            Jalalian::fromCarbon($this->ticket->created_at)->format('Y/m/d H:i'),
            $this->generateTrackingUrl()
        );
    }
}
