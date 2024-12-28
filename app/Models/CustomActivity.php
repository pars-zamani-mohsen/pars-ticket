<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomActivity extends Model
{
    protected $table = 'custom_activities';

    protected $fillable = ['user_id', 'type', 'description', 'properties'];

    protected $casts = [
        'properties' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
