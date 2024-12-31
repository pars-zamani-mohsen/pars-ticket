<?php

namespace App\Listeners;

use App\Events\TicketNotificationEvent;
use App\Services\Actions\Ticket\Notification\TicketNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketNotificationListener implements ShouldQueue
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
    public function handle(TicketNotificationEvent $event): void
    {
        try {
            if ($event->isCreated()) {
                $this->handleTicketCreated($event->ticket);

            } elseif ($event->isUpdated()) {
                $this->handleTicketUpdated($event->ticket, $event->changes);
            }

        } catch (\Exception $e) {
            logger()->error(__('ticket.error_on_send_notification_message'), [
                'ticket_id' => $event->ticket->id,
                'type' => $event->type,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function handleTicketCreated($ticket): void
    {
        $this->notificationService->handleTicketCreated($ticket);
    }

    private function handleTicketUpdated($ticket, array $changes): void
    {
        $this->notificationService->handleTicketUpdated($ticket, $changes);
    }
}
