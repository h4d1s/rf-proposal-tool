<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'website',
    ];

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
     * Get the team that owns the company.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the address that owns the client.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the projects for the client.
     */
    public function projects(): MorphMany
    {
        return $this->morphMany(Project::class, 'projectable');
    }

    /**
     * Get the activity that owns the activity type.
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Get the user's avatar.
     */
    public function proposals()
    {
        return $this->morphToMany(Proposal::class, 'email_proposalable', 'e_proposal')
                ->withPivot('token');
    }

    /**
     * Get the user's avatar.
     */
    public function payments()
    {
        return $this->morphToMany(Proposal::class, 'paymentable', 'payments')
                ->withPivot('is_paid');
    }
}
