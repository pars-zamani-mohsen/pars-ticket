<?php

declare(strict_types=1);

namespace App\Services\Actions\Ticket;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccessLevel
{
    public function handle(User $user, Ticket $ticket)
    {
        if ($user->can('show tickets all')) {
            return true;
        }

        if ($ticket->user_id === $user->id) {
            return true;
        }

        if ($user->can('show tickets all-in-category')) {
            $hasSharedCategory = $ticket->categories()
                ->whereHas('users', function($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->exists();

            if ($hasSharedCategory) {
                return true;
            }
        }

        return false;
    }
}
