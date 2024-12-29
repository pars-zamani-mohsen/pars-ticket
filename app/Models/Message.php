<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Message extends \Coderflex\LaravelTicket\Models\Message implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'message',
        'user_id',
        'ticket_id',
    ];

    protected $touches = ['ticket'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(config('laravel_ticket.models.ticket'));
    }

    public function medias(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model_type', 'media', 'model_id');
    }
}
