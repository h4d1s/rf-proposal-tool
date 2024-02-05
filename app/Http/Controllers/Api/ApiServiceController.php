<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ApiServiceController extends Controller
{
    /**
     * Api Collection Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Service::class, 'service');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->query('per_page', 6);
        $page = $request->query('page', 1);

        return ServiceResource::collection(Service::paginate($per_page, ['*'], 'page', $page));
    }
}
