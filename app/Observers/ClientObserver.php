<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\Activity;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     */
    public function created(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        Activity::where('causer_type', $client->getMorphClass())
            ->where('causer_id', $client->id)
            ->delete();
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "force deleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        Activity::where('causer_type', $client->getMorphClass())
            ->where('causer_id', $client->id)
            ->delete();
    }
}
