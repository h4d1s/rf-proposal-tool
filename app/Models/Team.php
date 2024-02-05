<?php

namespace App\Models;

use App\Traits\HasTimestampSerializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /**
     * The service templates that belong to the team.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * The email templates that belong to the tean.
     */
    public function emailTemplates()
    {
        return $this->hasMany(EmailTemplate::class);
    }

    /**
     * The service templates that belong to the team.
     */
    public function serviceTemplates()
    {
        return $this->hasMany(ServiceTemplate::class);
    }

    /**
     * The products that belong to the team.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * The users that belong to the team.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * The users that belong to the team.
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * The collections that belong to the team.
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
