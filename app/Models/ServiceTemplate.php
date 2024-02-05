<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
     * The items that belong to the service template.
     */
    public function items()
    {
        return $this->belongsToMany(ServiceTemplateItem::class, 's_t_s_t_item');
    }

    /**
     * Get the team that owns the service template.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the first product image.
     */
    public function total(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return $this->items()->sum('price');
            },
        );
    }
}
