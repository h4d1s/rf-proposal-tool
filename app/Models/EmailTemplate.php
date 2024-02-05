<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EmailTemplate extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'subject',
        'body',
    ];

    /**
     * Scope a query to only include for certain teams.
     */
    public function scopeForTeam(Builder $query, int $team_id): void
    {
        $query->whereHas('team', function ($query) use ($team_id) {
            $query->where('id', $team_id);
        });
    }

    /**
     * Get the proposal that owns the discussion table.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the proposal that owns the discussion table.
     */
    public function proposal()
    {
        return $this->hasMany(Proposal::class);
    }
}
