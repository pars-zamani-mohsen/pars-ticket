<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use App\Services\Actions\Ticket\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Ticket $ticket): Response
    {
        if ((new AccessLevel())->handle($user, $ticket)) {
            return Response::allow();
        }

        return Response::deny(__('ticket.you_dont_have_access_to_this_ticket_message'));
    }

    public function update(User $user, Ticket $ticket): Response
    {
        if ((new AccessLevel())->handle($user, $ticket)) {
            return Response::allow();
        }

        return Response::deny(__('ticket.you_dont_have_access_to_this_ticket_message'));
    }
}
