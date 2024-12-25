<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriorityEnum;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Services\Actions\Ticket\GetList;
use App\Services\Cache\CategoryCache;
use App\Services\Cache\LabelCache;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = GetList::handle();

        $categories = CategoryCache::allActive(config('pars-ticket.cache.timeout-long'));
        $labels = LabelCache::allActive(config('pars-ticket.cache.timeout-long'));

        return view('tickets.index', compact('tickets', 'categories', 'labels'));
    }

    public function create()
    {
        $categories = CategoryCache::allActive(config('pars-ticket.cache.timeout-long'));
        $labels = LabelCache::allActive(config('pars-ticket.cache.timeout-long'));
        $priorities = TicketPriorityEnum::getSelectBoxTransformItems()->toArray();
        $users = User::doesntHave('roles')->get();

        return view('tickets.create', compact('categories', 'labels', 'priorities', 'users'));
    }

    public function store(TicketRequest $request)
    {
        $validated = $request->validationData();

        try {
            $ticket = Ticket::create([
                'title' => $validated['title'],
                'message' => Purify::clean($validated['message']),
                'priority' => $validated['priority'],
                'user_id' => ($validated['user_id'] ?? auth()->id()),
            ]);

            if (!empty($validated['categories'])) {
                $ticket->categories()->attach($validated['categories']);
            }

            if (!empty($validated['labels'])) {
                $ticket->labels()->attach($validated['labels']);
            }

            return redirect()
                ->route('tickets.show', $ticket)
                ->with('success', __('ticket.create_ticket_message_done'));

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return back()
                ->withInput()
                ->with('error', __('ticket.create_ticket_message_error'));
        }
    }

    public function show(Ticket $ticket)
    {
        if (! $this->canAuthorizeRoleOrPermission(['show tickets all'])) {
            if ($ticket->user_id !== auth()->id()) {
                abort(404);
            }
        }

        $categories = CategoryCache::allActive(config('pars-ticket.cache.timeout-long'));
        $ticket->load(['user', 'categories', 'labels', 'messages.user']);

        return view('tickets.show', compact('ticket', 'categories'));
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        $validated = $request->validationData();

        $ticket->update($validated);

        if ($request->has('is_resolved') && $request->is_resolved) {
            $ticket->update(['status' => 'closed']);
        }

        if ($this->canAuthorizeRoleOrPermission('update tickets category')) {
            if (!empty($validated['categories'])) {
                $ticket->categories()->sync($validated['categories']);
            }
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', __('ticket.update_ticket_message_done'));
    }
}
