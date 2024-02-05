<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProposalState extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Get the proposals that owns the proposal state table.
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
