<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatusEnum;
use App\Models\Activity;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $activities = [];

        $usersCount = User::count();

        $ticketsCount = (auth()->user()->can(['show dashboard admin'])) ?
            Ticket::count() :
            Ticket::where('user_id', auth()->id())->count();

        $openTicketsCount = (auth()->user()->can(['show dashboard admin'])) ?
            Ticket::where('status', TicketStatusEnum::OPEN->value)->count() :
            Ticket::where('status', TicketStatusEnum::OPEN->value)->where('user_id', auth()->id())->count();

        return view('dashboard', compact(
            'activities',
            'usersCount',
            'ticketsCount',
            'openTicketsCount',
        ));
    }
}
