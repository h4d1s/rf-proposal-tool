<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTemplateItem extends Model
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
        'qty',
        'unit',
        'price',
    ];

    /**
     * The services that belong to the service item.
     */
    public function service_templates()
    {
        return $this->belongsToMany(ServiceTemplate::class, 's_t_s_t_item');
    }
}
