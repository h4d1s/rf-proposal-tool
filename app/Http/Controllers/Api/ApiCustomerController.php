<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCustomerController extends Controller
{
    /**
     * Api Client Controller Constructor
     */
    public function __construct()
    {
        // $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Show the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $customer)
    {
        $type = $request->query("type");
        $team_id = $request->user()->team->id;

        $data = null;
        if($type === "App\Models\Client") {
            $data = DB::table("clients")
                ->select(
                    "id",
                    DB::raw('CONCAT(first_name, " ", last_name) AS name'),
                    "email",
                    DB::raw("'App\\\Models\\\Client' as type"))
                ->where("team_id", $team_id)
                ->where("id", $customer);
        } else {
            $data = DB::table("companies")
                ->select("id", "name", "email", DB::raw("'App\\\Models\\\Company' as type"))
                ->where("team_id", $team_id)
                ->where("id", $customer);
        }


        return CustomerResource::collection($data->get());
    }

    /**
     * Search the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = null;

        $clients = DB::table("clients")
            ->select(
                "id",
                DB::raw('CONCAT(first_name, " ", last_name) AS name'),
                "email",
                DB::raw("'App\\\Models\\\Client' as type"))
            ->where("team_id", $team_id);

        $companies = DB::table("companies")
            ->select("id", "name", "email", DB::raw("'App\\\Models\\\Company' as type"))
            ->where("team_id", $team_id);

        $query = DB::table($clients->union($companies));

        $q = $request->query('q', '');
        $data = $query
                ->where('name', 'LIKE', '%'.$q.'%')
                ->limit(5)
                ->get();

        return CustomerResource::collection($data);
    }
}
