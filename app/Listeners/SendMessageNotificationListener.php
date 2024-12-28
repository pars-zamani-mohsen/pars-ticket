<?php

namespace App\Listeners;

use App\Events\MessageNotificationEvent;
use App\Services\Actions\Ticket\Notification\TicketNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessageNotificationListener implements ShouldQueue
{

    /**
     * Create the event listener.
     */
    public function __construct(public TicketNotificationService $notificationService)
    {

    }

    /**
     * Handle the event.
     */
    public function handle(MessageNotificationEvent $event): void
    {
        try {
            $this->notificationService->handleTicketReplied($event->ticket);

        } catch (\Exception $e) {
            logger()->error(__('ticket.error_on_send_notification_message'), [
                'ticket_id' => $event->ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
