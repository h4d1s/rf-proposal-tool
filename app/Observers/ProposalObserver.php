<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Proposal;

class ProposalObserver
{
    /**
     * Handle the Proposal "created" event.
     */
    public function created(Proposal $proposal): void
    {
        //
    }

    /**
     * Handle the Proposal "updated" event.
     */
    public function updated(Proposal $proposal): void
    {
        //
    }

    /**
     * Handle the Proposal "deleted" event.
     */
    public function deleted(Proposal $proposal): void
    {
        Activity::where('subject_type', $proposal->getMorphClass())
            ->where('subject_id', $proposal->id)
            ->delete();
    }

    /**
     * Handle the Proposal "restored" event.
     */
    public function restored(Proposal $proposal): void
    {
        //
    }

    /**
     * Handle the Proposal "force deleted" event.
     */
    public function forceDeleted(Proposal $proposal): void
    {
        Activity::where('subject_type', $proposal->getMorphClass())
            ->where('subject_id', $proposal->id)
            ->delete();
    }
}
