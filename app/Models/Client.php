<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    /**
     * Scope a query to only include only for certain teams.
     */
    public function scopeForTeam(Builder $query, int $team_id): void
    {
        $query->whereHas('team', function($q) use ($team_id) {
            $q->where('id', $team_id);
        });
    }

    /**
     * Get the user's first name.
     */
    public function fullname(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => implode(' ', [
                $attributes['first_name'],
                $attributes['last_name'],
            ]),
        );
    }

    /**
     * Get the projects for the client.
     */
    public function projects(): MorphMany
    {
        return $this->morphMany(Project::class, 'projectable');
    }

    /**
     * Get the team that owns the client.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the client's discussion.
     */
    public function discussion()
    {
        return $this->morphOne(Discussion::class, 'discussionable');
    }

    /**
     * Get the address that owns the client.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the address that owns the client.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
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
    
    // /**
    //  * Get the proposal for the client.
    //  */
    // public function proposals(): BelongsToMany
    // {
    //     return $this->belongsToMany(Proposal::class, 'e_proposal')
    //                 ->withPivot('token');
    // }

    // public function payments()
    // {
    //     return $this->belongsToMany(Proposal::class, 'payments')
    //                 ->withPivot('is_paid');
    // }
}
