<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PricingTableItemResource;
use App\Models\PricingTableItem;
use Illuminate\Http\Request;

class ApiPricingTableItemController extends Controller
{
    /**
     * ClientController Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(PricingTableItem::class, 'pricingTableItem');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = PricingTableItem::query();

        if($request->has('pricing_table_id')) {
            $pricing_table_id = $request->query('pricing_table_id');
            $query->where('pricing_table_id', $pricing_table_id);
        }

        $items = $query->get();

        return PricingTableItemResource::collection($items);
    }

    /**
     * Show the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PricingTableItem $pricingTableItem)
    {
        $pricingTableItem->delete();
    }
}
