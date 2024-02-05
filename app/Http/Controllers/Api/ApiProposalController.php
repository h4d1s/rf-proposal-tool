<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProposalResource;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ApiProposalController extends Controller
{
    /**
     * Api Collection Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Proposal::class, 'proposal');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Proposal::query();
        $query->forTeam($team_id);

        $per_page = $request->query('per_page', 6);
        $page = $request->query('page', 1);

        if ($request->has('include')) {
            $include = $request->get('include');
            $query->whereIn('id', $include);
        }

        if ($request->has('exclude')) {
            $exclude = $request->get('exclude');
            $query->whereNotIn('id', $exclude);
        }

        $proposals = $query->paginate($per_page, ['*'], 'page', $page);

        return ProposalResource::collection($proposals);
    }
}
