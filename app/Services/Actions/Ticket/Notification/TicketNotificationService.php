<?php

declare(strict_types=1);

namespace App\Services\Actions\Ticket\Notification;

use App\Contracts\EmailServiceInterface;
use App\Contracts\SMSServiceInterface;
use App\Models\Ticket;
use Morilog\Jalali\Jalalian;

class TicketNotificationService
{
    public function __construct(public SMSServiceInterface $smsService, public EmailServiceInterface $emailService)
    {

    }

    public function handleTicketCreated(Ticket $ticket): void
    {
        $ticket->loadMissing('user');

        $user = $ticket->user;

        if (! empty($user->mobile)) {
            $message = (new PerpareNotificationMessageService($ticket))->ticketCreatedPrepareSMSMessage();
            $this->sendSMSNotification($user->mobile, $message);

        } elseif (! empty($user->email)) {
            $subject = "تیکت شما با موفقیت ثبت شد";
            $content = (new PerpareNotificationMessageService($ticket))->ticketCreatedPrepareEmailContent();

            $this->sendEmailNotification($user->email, $subject, $content);
        }
    }

    public function handleTicketUpdated(Ticket $ticket, array $changes): void
    {
        $ticket->loadMissing('user');

        $user = $ticket->user;

        if (! empty($user->mobile)) {
            $message = (new PerpareNotificationMessageService($ticket))->ticketCreatedPrepareSMSMessage();
            $this->sendSMSNotification($user->mobile, $message);

        } elseif (! empty($user->email)) {
            $subject = "تیکت شما ویرایش شد";
            $content = (new PerpareNotificationMessageService($ticket))->ticketCreatedPrepareEmailContent();

            $this->sendEmailNotification($user->email, $subject, $content);
        }
    }

    private function sendSMSNotification(string $mobile, string $message): void
    {
        $this->smsService->send($mobile, $message);
    }

    private function sendEmailNotification(string $email, string $subject,  string $content): void
    {
        $this->emailService->send($email, $subject, $content);
    }
}
