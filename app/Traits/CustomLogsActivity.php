<?php

namespace App\Traits;

use App\Models\CustomActivity;

trait CustomLogsActivity
{
    public function logActivity($type, $description, $properties = [])
    {
        CustomActivity::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'description' => $description,
            'properties' => $properties
        ]);
    }
}
