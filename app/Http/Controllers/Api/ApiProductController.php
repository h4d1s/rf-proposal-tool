<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    /**
     * Api Collection Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Product::query();
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

        if ($request->has('collection')) {
            $collection_id = $request->get('collection');
            $query->whereHas('collections', function ($query) use ($collection_id) {
                $query->where('id', $collection_id);
            });
        }

        $products = $query->paginate($per_page, ['*'], 'page', $page);

        return ProductResource::collection($products);
    }
}
