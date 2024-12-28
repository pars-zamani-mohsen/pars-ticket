<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketNotificationEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Ticket $ticket
     * @param string $type created or updated
     * @param array $changes
     */
    public function __construct(public Ticket $ticket, public string $type, public array $changes = [])
    {

    }

    public function isCreated(): bool
    {
        return $this->type === 'created';
    }

    public function isUpdated(): bool
    {
        return $this->type === 'updated';
    }
}
