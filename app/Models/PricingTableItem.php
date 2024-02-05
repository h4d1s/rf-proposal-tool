<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingTableItem extends Model
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
        'description',
        'qty',
        'price',
        'unit',
    ];

    /**
     * Get the pricing table that owns the pricing table item.
     */
    public function pricingTable()
    {
        return $this->belongsTo(PricingTable::class);
    }
}
