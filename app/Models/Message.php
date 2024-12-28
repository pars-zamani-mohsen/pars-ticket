<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
