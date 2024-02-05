<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    use HasFactory;

    /**
     * Get the address that owns the country.
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
