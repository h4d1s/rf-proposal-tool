<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ApiProjectController extends Controller
{
    /**
     * ClientController Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

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

        $query = Project::query();
        $query->forTeam($team_id);

        $projects = $query->paginate($per_page, ['*'], 'page', $page);

        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        return ProjectResource::collection(Project::where('id', $project->id)->get());
    }

    /**
     * SearchCriteria the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $q = $request->query('q', '');
        $team_id = $request->user()->team->id;
        
        $query = Project::query();
        $query->forTeam($team_id);
        $query->where('name', 'LIKE', '%'.$q.'%');

        $projects = $query
            ->limit(5)
            ->get();

        return ProjectResource::collection($projects);
    }
}
