<?php

namespace App\Http\Controllers;

use App\Services\Actions\ActivityLog\CreateActivityLog;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function destroy(Request $request, Media $media)
    {
        $this->authorizeRoleOrPermission('delete tickets files');

//        $this->authorize('create', [Media::class, $ticket]);

        CreateActivityLog::handleForDeleteMedia($media, auth()->user());

        $media->delete();

        return response()->json([
            'message' => __('ticket.deleted_file_success')
        ]);
    }
}
