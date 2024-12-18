<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\Actions\Ticket\GetList;
use Coderflex\LaravelTicket\Enums\Priority;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = GetList::handle();
        $categories = Category::all();
        $labels = Label::all();

        return view('tickets.index', compact('tickets', 'categories', 'labels'));
    }

    public function create()
    {
        $categories = Category::where('is_visible', true)->get();
        $labels = Label::where('is_visible', true)->get();
        $priorities = ['low' => 'کم', 'normal' => 'متوسط', 'high' => 'زیاد'];

        return view('tickets.create', compact('categories', 'labels', 'priorities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => ['required', Rule::in(collect(Priority::cases())->pluck('value'))],
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id'
        ]);

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

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'is_resolved' => 'sometimes|boolean',
            'is_locked' => 'sometimes|boolean',
            'assigned_to' => 'sometimes|nullable|exists:users,id',
            'status' => 'sometimes|in:open,closed',
        ]);

        $ticket->update($validated);

        if ($request->has('is_resolved') && $request->is_resolved) {
            $ticket->update(['status' => 'closed']);
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'تیکت با موفقیت بروزرسانی شد.');
    }
}
