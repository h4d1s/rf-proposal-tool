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

class Proposal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cover_letter',
        'conclusion',
        'state',
        'expiration_date'
    ];

    /**
     * Scope a query to only include only for certain teams.
     */
    public function scopeForTeam(Builder $query, int $team_id): void
    {
        $query->whereHas('project.projectable', function ($query) use ($team_id) {
            $query->whereNotNull('id');
            $query->whereHas('team', function ($nestedQuery) use ($team_id) {
                $nestedQuery->where('id', $team_id);
            });
        });
    }

    /**
     * Get the sum of all prices.
     */
    public function total(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // products /
                // services

                // TODO: Products / Services
                return $this->products->pluck('price')->sum(); ///+ $this->services();
            }
        );
    }

    /**
     * Get the user for the proposal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the notes for the proposal.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class)->orderBy('created_at', 'DESC');
    }

    /**
     * Get the discussions for the proposal.
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * Get the products for the proposal.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function pricingTable(): BelongsTo
    {
        return $this->belongsTo(PricingTable::class);
    }

    /**
     * Get the state for the proposal.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(ProposalState::class, "proposal_state_id");
    }

    /**
     * Get the project for the proposal.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the email template for the proposal.
     */
    public function emailTemplate(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class);
    }

    /**
     * Get the user's avatar.
     */
    public function clients()
    {
        return $this->morphedByMany(Client::class, 'email_proposalable', 'e_proposal')
                ->withPivot('token');
    }

    /**
     * Get the user's avatar.
     */
    public function companies()
    {
        return $this->morphedByMany(Company::class, 'email_proposalable', 'e_proposal')
                ->withPivot('token');
    }

    /**
     * Get the user's avatar.
     */
    public function payments_companies()
    {
        return $this->morphedByMany(Company::class, 'paymentable', 'payments')
                ->withPivot('is_paid');
    }

    /**
     * Get the user's avatar.
     */
    public function payments_clients()
    {
        return $this->morphedByMany(Client::class, 'paymentable', 'payments')
                ->withPivot('is_paid');
    }
}
