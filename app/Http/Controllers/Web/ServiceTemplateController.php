<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceTemplate\StoreServiceTemplateRequest;
use App\Http\Requests\ServiceTemplate\UpdateServiceTemplateRequest;
use App\Models\ServiceTemplate;
use Illuminate\Http\Request;

class ServiceTemplateController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ServiceTemplate::class, 'service_template');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = ServiceTemplate::query();
        $query = $query->forTeam($team_id);

        if (
            $request->filled(['service_template', 'action']) &&
            $request->query('action') === 'delete'
        ) {
            $ids = $request->query('service_template');
            ServiceTemplate::whereIn('id', $ids)->each(function($service_template) {
                $service_template->delete();
            });
            $request->request->remove('service_template');

            $service_templates = $query
                ->all()
                ->paginate(10)
                ->withQueryString();

            return back()
                ->with('service_templates', compact('service_templates'))
                ->with('status', __('Service templates deleted!'));
        }

        if ($request->filled('search')) {
            $q = $request->query('search');
            $query = $query->where('name', 'LIKE', '%'.$q.'%');
        }

        if ($request->filled(['order', 'orderby'])) {
            $order = $request->query('order');
            $orderby = $request->query('orderby');
            $query = $query->orderBy($orderby, $order);
        }

        $service_templates = $query
            ->paginate(10)
            ->withQueryString();

        return view('settings.service-templates.index', compact('service_templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.service-templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceTemplateRequest $request)
    {
        $validated = $request->safe()->all();
        $team = $request->user()->team;

        $service_template = ServiceTemplate::make($validated);
        $service_template->team()->associate($team);
        $service_template->save();

        return redirect()
            ->route('service-templates.index')
            ->with('status', __('Service template created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceTemplate $service_template)
    {
        return view('settings.service-templates.show', compact('service_template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceTemplate $service_template)
    {
        return view('settings.service-templates.edit', compact('service_template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceTemplateRequest $request, ServiceTemplate $service_template)
    {
        $validated = $request->safe()->all();
        $service_template->update($validated);

        return redirect()
            ->route('service-templates.index')
            ->with('status', __('Service template updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceTemplate $service_template)
    {
        $service_template->delete();

        return back()
            ->with('status', __('Service template deleted!'));
    }
}
