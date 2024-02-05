<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Address;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
/**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;

        $query = Company::query();
        $query = $query->forTeam($team_id);

        if (
            $request->filled(['company', 'action']) &&
            $request->query('action') === 'delete'
        ) {
            $ids = $request->query('company');
            Company::whereIn('id', $ids)->each(function($project) {
                $project->delete();
            });
            $request->request->remove('company');

            $companies = $query
                ->paginate(10)
                ->withQueryString();

            return back()
                ->with('companies', $companies)
                ->with('status', __('Companies deleted!'));
        }

        if ($request->filled('search')) {
            $q = $request->query('search', '');
            $query->where('name', 'LIKE', '%'.$q.'%');
        }

        if ($request->filled(['order', 'orderby'])) {
            $order = $request->query('order', '');
            $orderby = $request->query('orderby', '');

            $query->orderBy($orderby, $order);
        }

        $companies = $query
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('companies.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $user = $request->user();
        $validated = $request->safe();
        $new_company_data = $request->safe()->except([
            'address',
            'postal_code',
            'city',
            'country',
        ]);
        $company = Company::make($new_company_data);
        $company->team()->associate($user->team);

        // Address

        if($validated->has(['address', 'postal_code', 'city', 'country'])) {
            $country = Country::where("id", $validated['country'])->first();
            $address = Address::make([
                'address' => $validated['address'],
                'postal_code' => $validated['postal_code'],
                'city' => $validated['city'],
            ]);
            $address->country()->associate($country)->save();
            $company->address()->associate($address);
        }

        $company->save();

        return redirect()
            ->route('companies.index')
            ->with('status', __('Company created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $countries = Country::all();
        return view('companies.edit', compact('company', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $validated = $request->safe();
        $company_data = $request->safe()->except([
            'address',
            'postal_code',
            'city',
            'country',
        ]);
        $company->update($company_data);

        // Address

        if($validated->has(['address', 'postal_code', 'city', 'country'])) {
            $country = Country::where("id", $validated['country'])->first();
            $address = Address::make([
                'address' => $validated['address'],
                'postal_code' => $validated['postal_code'],
                'city' => $validated['city'],
            ]);
            $address->country()->associate($country)->save();
            $company->address()->associate($address)->save();
        }

        return back()->with('status', __('Company updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('status', __('Company deleted!'));
    }
}
