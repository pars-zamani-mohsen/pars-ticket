<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Ticket $ticket)
    {
        return $this->checkAccess($user, $ticket);
    }

    public function update(User $user, Ticket $ticket): Response
    {
        return $this->checkAccess($user, $ticket);
    }

    private function checkAccess(User $user, Ticket $ticket)
    {
        if ($user->can('show tickets all')) {
            return Response::allow();
        }

        $cacheKey = "ticket_access_{$user->id}_{$ticket->id}";

        return cache()->remember($cacheKey, now()->addMinutes(30), function() use ($user, $ticket) {
            if ($ticket->user_id === $user->id) {
                return Response::allow();
            }

            if ($user->can('show tickets all-in-category')) {
                $hasSharedCategory = $ticket->categories()
                    ->whereHas('users', function($query) use ($user) {
                        $query->where('users.id', $user->id);
                    })
                    ->exists();

                if ($hasSharedCategory) {
                    return Response::allow();
                }
            }

            return Response::deny(__('ticket.you_dont_have_access_to_this_ticket_message'));
        });
    }
}
