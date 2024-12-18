<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends \Coderflex\LaravelTicket\Models\Ticket implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'message',
        'priority',
        'status',
        'is_resolved',
        'is_locked',
        'assigned_to'
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ticket-attachments');
    }
}
