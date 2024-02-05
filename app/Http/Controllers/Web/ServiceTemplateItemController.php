<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceTemplateItem\UpdateServiceTemplateItemRequest;
use App\Http\Requests\ServiceTemplateItem\StoreServiceTemplateItemRequest;
use App\Models\ServiceTemplate;
use App\Models\ServiceTemplateItem;

class ServiceTemplateItemController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ServiceTemplateItem::class, 'service_template_item');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("settings.service-templates.items.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceTemplateItemRequest $request, ServiceTemplate $service_template)
    {
        $validated = $request->safe()->all();
        $item = ServiceTemplateItem::make($validated);
        $item->save();
        $item->service_templates()->attach($service_template->id);

        return redirect()
            ->route('service-templates.show', $service_template)
            ->with('status', __('Service templates created!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceTemplate $service_template, ServiceTemplateItem $service_template_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceTemplate $service_template, ServiceTemplateItem $service_template_item)
    {
        return view("settings.service-templates.items.edit", compact('service_template_item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceTemplateItemRequest $request, ServiceTemplate $service_template, ServiceTemplateItem $service_template_item)
    {
        $validated = $request->safe()->all();
        $service_template_item->update($validated);

        return back()
            ->with('status', __('Item updated!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceTemplate $service_template, ServiceTemplateItem $service_template_item)
    {
        $service_template_item->delete();

        return back()
            ->with('status', __('Item deleted!'));
    }
}
