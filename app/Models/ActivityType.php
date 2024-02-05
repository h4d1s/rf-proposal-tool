<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    use HasFactory;

    /**
     * Get the activity that owns the activity type.
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
