<?php

namespace App\Traits;

use App\Models\Activity;

trait LogsActivity
{
    public function logActivity($type, $description, $properties = [])
    {
        Activity::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'description' => $description,
            'properties' => $properties
        ]);
    }
}
