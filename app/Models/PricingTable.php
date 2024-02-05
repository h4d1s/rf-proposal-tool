<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PricingTable extends Model
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
    ];

    /**
     * Get the user's first name.
     */
    public function total(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $sum = 0;
                foreach($this->items as $item) {
                    $sum += $item->qty * $item->price;
                }
                return $sum;
            },
        );
    }

    /**
     * Scope a query to only include only for certain teams.
     */
    public function scopeForTeam(Builder $query, int $team_id): void
    {
        $query->whereHas('proposal.project.projectable', function ($query) use ($team_id) {
            $query->whereNotNull("id");
            $query->whereHas('team', function ($nestedQuery) use ($team_id) {
                $nestedQuery->where('id', $team_id);
            });
        });
    }

    /**
     * Get the proposal that owns the pricing table.
     */
    public function proposal(): HasOne
    {
        return $this->hasOne(Proposal::class);
    }

    /**
     * Get the items that owns the pricing table.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PricingTableItem::class);
    }
}
