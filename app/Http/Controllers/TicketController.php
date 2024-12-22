<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriorityEnum;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Services\Actions\Ticket\GetList;
use App\Services\Cache\CategoryCache;
use App\Services\Cache\LabelCache;
use Illuminate\Http\Request;

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

        return view('tickets.create', compact('categories', 'labels', 'priorities'));
    }

    public function store(TicketRequest $request)
    {
        $validated = $request->validationData();

        try {
            $ticket = Ticket::create([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'priority' => $validated['priority'],
                'user_id' => auth()->id(),
            ]);

            if (!empty($validated['categories'])) {
                $ticket->categories()->attach($validated['categories']);
            }

            if (!empty($validated['labels'])) {
                $ticket->labels()->attach($validated['labels']);
            }

            return redirect()
                ->route('tickets.show', $ticket)
                ->with('success', 'تیکت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'خطا در ایجاد تیکت. لطفا دوباره تلاش کنید.');
        }
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'categories', 'labels', 'messages.user']);
        return view('tickets.show', compact('ticket'));
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        $validated = $request->validationData();

        $ticket->update($validated);

        if ($request->has('is_resolved') && $request->is_resolved) {
            $ticket->update(['status' => 'closed']);
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'تیکت با موفقیت بروزرسانی شد.');
    }
}
