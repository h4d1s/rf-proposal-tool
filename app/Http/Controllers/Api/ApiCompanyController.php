<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class ApiCompanyController extends Controller
{
    /**
     * Api Client Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    /**
     * Show the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return CompanyResource::collection(Company::where('id', $company->id)->get());
    }

    /**
     * Search the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Company::query();
        $query->forTeam($team_id);

        if($request->has('q')) {
            $q = $request->query('q', '');
            $query->where('name', 'LIKE', '%'.$q.'%');
        }

        $companies = $query
            ->limit(5)
            ->get();

        return CompanyResource::collection($companies);
    }
}
