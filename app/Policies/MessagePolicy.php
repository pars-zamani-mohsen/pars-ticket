<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\Ticket;
use App\Models\User;
use App\Services\Actions\Ticket\AccessLevel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MessagePolicy
{
    use HandlesAuthorization;

    public function create(User $user, Ticket $ticket): Response
    {
        if ((new AccessLevel())->handle($user, $ticket)) {
            return Response::allow();
        }

        return Response::deny(__('ticket.you_dont_have_access_to_this_ticket_message'));
    }
}
