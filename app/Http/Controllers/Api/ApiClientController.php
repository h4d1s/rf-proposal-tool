<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApiClientController extends Controller
{
    /**
     * Api Client Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Client::query();
        $query->forTeam($team_id);

        $per_page = $request->query('per_page', 6);
        $page = $request->query('page', 1);

        $clients = $query->paginate($per_page, ['*'], 'page', $page);

        return ClientResource::collection($clients);
    }

    /**
     * Show the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return ClientResource::collection(Client::where('id', $client->id)->get());
    }

    /**
     * Search the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Client::query();
        $query->forTeam($team_id);

        $q = $request->query('q', '');
        $clients = $query
                ->where(function (Builder $query) use ($q) {
                    $query
                        ->where('first_name', 'LIKE', '%'.$q.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$q.'%');
                })
                ->limit(5)
                ->get();
        return ClientResource::collection($clients);
    }
}
