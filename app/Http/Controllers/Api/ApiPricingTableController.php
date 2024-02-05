<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PricingTableResource;
use App\Models\PricingTable;
use Illuminate\Http\Request;

class ApiPricingTableController extends Controller
{
    /**
     * Api Collection Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(PricingTable::class, 'pricingTable');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = PricingTable::query();
        $query->forTeam($team_id);

        $per_page = $request->query('per_page', 6);
        $page = $request->query('page', 1);

        $tables = $query->paginate($per_page, ['*'], 'page', $page);

        return PricingTableResource::collection($tables);
    }

    /**
     * Show the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return PricingTableResource::collection(PricingTable::where('id', $id)->get());
    }
}
