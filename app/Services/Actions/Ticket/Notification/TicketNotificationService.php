<?php

declare(strict_types=1);

namespace App\Services\Actions\Ticket\Notification;

use App\Contracts\EmailServiceInterface;
use App\Contracts\SMSServiceInterface;
use App\Models\Ticket;
use App\Models\User;

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
            $this->sendSMSNotification($user, $message);


        } elseif (! empty($user->email)) {
            $subject = __('ticket.ticket_for_your_is_created');
            $content = (new PerpareNotificationMessageService($ticket))->ticketCreatedPrepareEmailContent();

            $this->sendEmailNotification($user, $subject, $content);
        }
    }

    public function handleTicketUpdated(Ticket $ticket, array $changes): void
    {
        $ticket->loadMissing('user');

        $user = $ticket->user;

        if (! empty($user->mobile)) {
            $message = (new PerpareNotificationMessageService($ticket))->ticketUpdatedPrepareSMSMessage($changes);
            $this->sendSMSNotification($user, $message);

        } elseif (! empty($user->email)) {
            $subject = __('ticket.your_ticket_is_updated');
            $content = (new PerpareNotificationMessageService($ticket))->ticketUpdatedPrepareEmailContent($changes);

            $this->sendEmailNotification($user, $subject, $content);
        }
    }

    public function handleTicketReplied(Ticket $ticket): void
    {
        $ticket->loadMissing('user');

        $user = $ticket->user;

        if (! empty($user->mobile)) {
            $message = (new PerpareNotificationMessageService($ticket))->ticketRepliedPrepareSMSMessage();
            $this->sendSMSNotification($user, $message);

        } elseif (! empty($user->email)) {
            $subject = __('ticket.answared_to_your_ticket');
            $content = (new PerpareNotificationMessageService($ticket))->ticketRepliedPrepareEmailContent();

            $this->sendEmailNotification($user, $subject, $content);
        }
    }

    private function sendSMSNotification(User $user, string $message): void
    {
        $this->smsService->send($user->mobile, $message);
        $user->logActivity('sms', 'ارسال پیامک', ['type' => 'sms', 'message' => $message]);
    }

    private function sendEmailNotification(User $user, string $subject,  string $content): void
    {
        $this->emailService->send($user->email, $subject, $content);
        $user->logActivity('email', 'ارسال ایمیل', ['type' => 'email', 'message' => $subject]);
    }
}
