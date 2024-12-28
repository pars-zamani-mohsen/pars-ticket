<?php

namespace App\Http\Controllers;

use App\Events\MessageNotificationEvent;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class MessageController extends Controller
{
    public function store(MessageRequest $request, Ticket $ticket)
    {
        $this->authorize('create', [Message::class, $ticket]);

        $message = $ticket->messages()->create([
            'message' => Purify::clean($request->message),
            'user_id' => auth()->id(),
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $randStr = Str::uuid();

                $message->addMedia($file)
                    ->usingFileName("{$randStr}.{$file->getClientOriginalExtension()}")
                    ->toMediaCollection('message-attachments');
            }
        }

        if (auth()->id() != $ticket->user_id) {
            event(new MessageNotificationEvent($ticket));
        }

        return back()->with('success', __('ticket.message_reply_success'));
    }
}
