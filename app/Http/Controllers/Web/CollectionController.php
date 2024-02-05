<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collection\StoreCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
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

        if ($request->filled('search')) {
            $q = $request->query('search', '');
            $query->where('name', 'LIKE', '%'.$q.'%');
        }
        
        $collections = $query
            ->orderBy('created_at', 'DESC')
            ->paginate(6)
            ->withQueryString();

        return view('collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('collections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectionRequest $request)
    {
        $user = $request->user();
        $data = $request->safe();
        $new_collection_data = $data->except('products');

        $collection = Collection::make($new_collection_data);
        $collection->team()->associate($user->team)->save();

        // Products

        if($data->has("products")) {
            $collection->products()->attach($data["products"]);
        }

        return redirect()
            ->route('collections.index')
            ->with('status', __('Collection created!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        $collection = Collection::with('products')
            ->find($collection->id);

        return view('collections.show', compact('collection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        return view('collections.edit', compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCollectionRequest $request, Collection $collection)
    {
        $validated = $request->safe();
        $collection_data = $request->safe()->except("product");
        $collection->update($collection_data);

        if($validated->has("products")) {
            $collection->products()->sync($validated['products']);
        }

        return back()->with('status', __('Collection updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        $collection->delete();

        return redirect()
            ->route('collections.index')
            ->with('status', __('Collection deleted!'));
    }
}
