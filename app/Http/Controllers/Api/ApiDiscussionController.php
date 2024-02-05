<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionResource;
use App\Models\Client;
use App\Models\Company;
use App\Models\Discussion;
use Illuminate\Http\Request;

class ApiDiscussionController extends Controller
{
    /**
     * Api Collection Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Discussion::class, 'discussion');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->query('per_page', 6);
        $page = $request->query('page', 1);

        $query = Discussion::query();

        if($request->has('proposal')) {
            $proposal_id = $request->query('proposal');
            $query->whereHas("proposal", function($query) use ($proposal_id) {
                $query->where('id', $proposal_id);
            });
        }

        $discussions = $query
            ->orderBy('created_at', 'DESC')
            ->paginate($per_page, ['*'], 'page', $page);

        $discussions->setCollection($discussions->getCollection()->reverse());

        return DiscussionResource::collection($discussions);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required',
            'proposal' => 'required|numeric',
            'customer' => 'required|numeric',
            'customer_type' => 'required',
        ]);

        $discussion = Discussion::make([
            'body' => $validated['message'],
        ]);

        if($request->filled('proposal')) {
            $discussion->proposal()->associate($validated['proposal']);
        }

        if($request->filled(['customer', 'customer_type'])) {
            $customer = null;
            if($request->input('customer_type') === "App\\Models\\Client") {
                $customer = Client::where('id', $validated['customer'])->first();
            } else {
                $customer = Company::where('id', $validated['customer'])->first();
            }
            $discussion->discussionable()->associate($customer);
        }

        $discussion->save();
    }
}
