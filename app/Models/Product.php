<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rf_id',
        'name',
        'description',
        'price'
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
     * Get the team that owns the product.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * The proposals that belong to the product.
     */
    public function proposals()
    {
        return $this->belongsToMany(Proposal::class);
    }

    /**
     * Get the collections for the product.
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class);
    }

    /**
     * Get the post's image.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
