<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address',
        'postal_code',
        'city',
    ];

    /**
     * Get the client that owns the address.
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Get the country that owns the address.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
