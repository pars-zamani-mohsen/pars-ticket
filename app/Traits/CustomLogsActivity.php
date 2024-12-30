<?php

namespace App\Traits;

use App\Models\CustomActivity;

trait CustomLogsActivity
{
    public function logActivity($type, $description, $properties = []): void
    {
        CustomActivity::create([
            'user_id' => $this->id,
            'type' => $type,
            'description' => $description,
            'properties' => $properties
        ]);
    }
}
