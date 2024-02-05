<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Company;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
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

        $query = Project::query();
        $query = $query->forTeam($team_id);

        if (
            $request->filled(['project', 'action']) &&
            $request->query('action') === 'delete'
        ) {
            $ids = $request->query('project');
            Project::whereIn('id', $ids)->each(function($project) {
                $project->delete();
            });
            $request->request->remove('project');

            $projects = $query
                ->with('proposals')
                ->paginate(10)
                ->withQueryString();

            return back()
                ->with('projects', $projects)
                ->with('status', __('Projects deleted!'));
        }

        if ($request->filled('search')) {
            $q = $request->query('search', '');
            $query->where('name', 'LIKE', '%'.$q.'%');
        }

        if ($request->filled(['date_from', 'date_to'])) {
            $date_from = $request->query('date_from', '');
            $date_to = $request->query('date_to', '');
            $start_date = Carbon::createFromFormat('Y-m-d', $date_from)->startOfDay();
            $end_date = Carbon::createFromFormat('Y-m-d', $date_to)->endOfDay();

            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        if ($request->filled(['order', 'orderby'])) {
            $order = $request->query('order', '');
            $orderby = $request->query('orderby', '');

            $query->orderBy($orderby, $order);
        }

        if ($request->filled('client')) {
            $client_id = $request->query('client');
            $query->with('client');
            $query->whereHas('client', function ($query) use ($client_id) {
                $query->where('id', $client_id);
            });
        }

        $projects = $query
            ->with('proposals')
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->safe()->only("customer", "customer_type");
        $new_project_data = $request->safe()->except([
            "customer",
            "customer_type"
        ]);
        $project = Project::make($new_project_data);

        $customer = null;
        if($validated["customer_type"] === "App\Models\Client") {
            $customer = Client::where("id", $validated["customer"])->first();
        } else {
            $customer = Company::where("id", $validated["customer"])->first();
        }
        $project->projectable()->associate($customer);
        $project->save();

        return redirect()
            ->route('projects.index')
            ->with('status', __('Project created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $project = Project::with('proposals')->find($project->id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $project = Project::with('proposals')->find($project->id);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->safe()->only("customer", "customer_type");
        $new_project_data = $request->safe()->except([
            "customer",
            "customer_type"
        ]);
        $project->update($new_project_data);

        $customer = null;
        if($validated["customer_type"] === "App\Models\Client") {
            $customer = Client::where("id", $validated["customer"])->first();
        } else {
            $customer = Company::where("id", $validated["customer"])->first();
        }

        $project->projectable()->associate($customer);
        $project->save();

        return back()->with('status', __('Project updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('status', __('Project deleted!'));
    }
}
