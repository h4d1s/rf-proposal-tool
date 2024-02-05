<?php

namespace App\Exports;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProposalsExport implements FromQuery, WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Cover letter',
            'Conclusion',
            'Project',
            'State',
        ];
    }

    /**
     * @var Proposal
     */
    public function map($proposal): array
    {
        return [
            $proposal->id,
            $proposal->name,
            $proposal->cover_letter,
            $proposal->conclusion,
            $proposal->project->name,
            $proposal->state->name,
        ];
    }

    public function query()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $query = Proposal::query();
        $query = $query
            ->whereHas("user", function($q) use ($user) {
                $q->whereHas("team", function($subquery) use ($user) {
                    $subquery->where('id', $user->team->id);
                });
            });
        return $query;
    }
}
