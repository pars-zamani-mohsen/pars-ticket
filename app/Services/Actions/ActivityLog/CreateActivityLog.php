<?php

declare(strict_types=1);

namespace App\Services\Actions\ActivityLog;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CreateActivityLog
{
    public static function handleForDeleteMedia(Media $media, User $user): bool
    {
        DB::beginTransaction();

        try {
            $propertie = [];

            if ($media->model_type === Message::class) {
                $message = Message::query()
                    ->with('ticket:id,title,user_id', 'ticket.user:id,name')
                    ->find($media->model_id);

                $propertie = [
                    'message' => $message,
                ];

                $now = Jalalian::now()->format('l، d F Y، H:i');
                $message->update([
                    'message' => "{$message->message} \n <p class='text-red-600'>فایل {$media->name} توسط {$user->name} در تاریخ {$now} حذف شد</p>",
                ]);
            }

            activity()
                ->causedBy(auth()->user())
                ->performedOn($media)
                ->event('deleted')
                ->withProperties($propertie)
                ->log('The user has deleted file');

            DB::commit();

            return true;

        } catch (\Throwable $th) {
            DB::rollBack();

            \Log::error($th->getMessage());

            return false;
        }
    }
}
