<?php

namespace App\Http\Controllers\Web;

use App\Actions\Client\CreateClient;
use App\Actions\Client\DeleteClient;
use App\Actions\Client\GetAllClient;
use App\Actions\Client\GetClient;
use App\Actions\Client\UpdateClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Address;
use App\Models\Client;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private const SHOW_ROUTE = 'clients.index';

    /**
     * ClientController Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Client::query();
        $query->forTeam($team_id);

        if (
            $request->filled(['client', 'action']) &&
            $request->query('action') === 'delete'
        ) {
            $ids = $request->query('client');
            Client::whereIn('id', $ids)->each(function($client) {
                $client->delete();
            });

            $request->request->remove('client');

            $clients = $query
                ->paginate(10)
                ->withQueryString();

            return back()
                ->with('clients', compact('clients'))
                ->with('status', __('Clients deleted!'));
        }

        if ($request->filled('search')) {
            $q = $request->query('search');
            $query = $query->where('first_name', 'LIKE', '%'.$q.'%');
            $query = $query->orWhere('last_name', 'LIKE', '%'.$q.'%');
        }

        if ($request->filled(['order', 'orderby'])) {
            $order = $request->query('order');
            $orderby = $request->query('orderby');
            $query = $query->orderBy($orderby, $order);
        }

        $clients = $query
            ->paginate(10)
            ->withQueryString();

        return response()->view(self::SHOW_ROUTE, compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return response()->view('clients.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $user = $request->user();
        $validated = $request->safe();
        $new_client_data = $request->safe()->except([
            'company',
            'address',
            'postal_code',
            'city',
            'country',
        ]);
        $client = Client::make($new_client_data);
        $client->team()->associate($user->team)->save();

        // Address

        if($validated->has(['address', 'postal_code', 'city', 'country'])) {
            $country = Country::where("id", $validated["country"])->first();
            $address = Address::make([
                'address' => $validated['address'],
                'postal_code' => $validated['postal_code'],
                'city' => $validated['city'],
            ]);
            $address->country()->associate($country)->save();
            $client->address()->associate($address)->save();
        }

        // Company
        
        if($validated->has("company")) {
            $company = Company::where("id", $validated['company'])->first();
            $client->company()->associate($company)->save();
        }

        return redirect()
            ->route(self::SHOW_ROUTE)
            ->with('status', __('Client created!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return response()->view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $countries = Country::all();
        return response()->view('clients.edit', compact('client', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->safe();
        $client_data = $request->safe()->only([
            'title',
            'first_name',
            'last_name',
            'email',
            'phone',
        ]);
        $address_data = $request->safe()->only([
            'address',
            'postal_code',
            'city',
        ]);
        $country_id = $request->safe()->only(['country']);
        $country = Country::where('id', $country_id)->first();

        $client->update($client_data);
        $client->address()->update($address_data);
        $client->address->country()->associate($country)->save();

        // Company

        if($validated->has("company")) {
            $company = Company::where("id", $validated['company'])->first();
            $client->company()->associate($company)->save();
        }

        return back()
            ->with('status', __('Client updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route(self::SHOW_ROUTE)
            ->with('status', __('Client deleted!'));
    }
}
