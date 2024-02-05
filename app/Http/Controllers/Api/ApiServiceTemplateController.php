<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceTemplateResource;
use App\Models\ServiceTemplate;
use Illuminate\Http\Request;

class ApiServiceTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $per_page = $request->query('per_page', 6);
        $page = $request->query('page', 1);

        $query = ServiceTemplate::query();
        $query->forTeam($team_id);

        $service_templates = $query->paginate($per_page, ['*'], 'page', $page);

        return ServiceTemplateResource::collection($service_templates);
    }
}
