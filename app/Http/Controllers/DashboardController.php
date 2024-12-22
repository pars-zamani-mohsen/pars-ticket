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
        $activities = Activity::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $usersCount = User::count();

        $ticketsCount = (auth()->user()->hasAnyRole(['super-admin', 'admin'])) ?
            Ticket::count() :
            Ticket::where('user_id', auth()->id())->count();

        $openTicketsCount = (auth()->user()->hasAnyRole(['super-admin', 'admin'])) ?
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
