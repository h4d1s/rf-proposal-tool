<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use Illuminate\Http\Request;

class ApiCollectionController extends Controller
{
    /**
     * Api Collection Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Collection::class, 'collection');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Collection::query();
        $query->forTeam($team_id);

        $per_page = $request->query('per_page', 6);
        $page = $request->query('page', 1);

        $collections = $query->paginate($per_page, ['*'], 'page', $page);

        return CollectionResource::collection($collections);
    }

    /**
     * SearchCriteria the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Collection::query();
        $query->forTeam($team_id);

        $q = $request->query('q', '');
        $collections = $query
                    ->where('name', 'like', '%'.$q.'%')
                    ->limit(5)
                    ->get();

        return CollectionResource::collection($collections);
    }
}
