<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
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
     * Get the team that owns the collection.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the products for the collection.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get the first product image.
     */
    public function image(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $product = $this->products()->first();
                if (!$product) {
                    return null;
                }

                return $product->images()->first();
            },
        );
    }

    /**
     * Get the sum of all product prices.
     */
    public function price(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return $this->products()->pluck('price')->sum();
            }
        );
    }
}
