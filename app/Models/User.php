<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasPermission;
use App\Traits\HasRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRole, HasPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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
     * Scope a query to only include only for certain teams.
     */
    public function scopeAllWithoutCurrent(Builder $query, int $id): void
    {
        $query->whereNot(function ($query) use ($id) {
            $query->where('id', $id);
        });
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * The roles that belong to the user.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * The activities that belong to the user.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * The activities that belong to the user.
     */
    public function proposals()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the user's discussion.
     */
    public function discussion()
    {
        return $this->morphOne(Discussion::class, 'discussionable');
    }

    /**
     * The team that belong to the user.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the user's avatar.
     */
    public function avatar()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
