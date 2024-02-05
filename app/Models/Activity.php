<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * Scope a query to only include only for certain teams.
     */
    public function scopeForTeam(Builder $query, int $team_id): void
    {
        $query->whereHas('team', function ($query) use ($team_id) {
            $query->where('id', $team_id);
        });
    }

    /**
     * Get the team associated with the activity.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the phone associated with the user.
     */
    public function activity_type()
    {
        return $this->belongsTo(ActivityType::class);
    }

    /**
     * Get the parent subject model.
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Get the parent causer model.
     */
    public function causer()
    {
        return $this->morphTo();
    }
}
