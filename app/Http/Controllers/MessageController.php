<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MessageController extends Controller
{
    public function store(MessageRequest $request, Ticket $ticket)
    {
        $message = $ticket->messages()->create([
            'message' => $request->message,
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

        return back()->with('success', 'پیام با موفقیت ارسال شد.');
    }

    public function destroy(Request $request, Media $media)
    {
        $this->authorizeRoleOrPermission('delete ticket file');

        $media->delete();

        return response()->json([
            'message' => 'فایل با موفقیت حذف شد'
        ]);
    }
}
