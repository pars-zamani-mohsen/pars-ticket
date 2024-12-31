<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends \Coderflex\LaravelTicket\Models\Category
{
    protected $fillable = [
        'name',
        'slug',
        'is_visible',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
