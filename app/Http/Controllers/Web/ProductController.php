<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = Product::query();
        $query->forTeam($team_id);

        if (
            $request->filled(['product', 'action']) &&
            $request->query('action') === 'delete'
        ) {
            $ids = $request->query('product');
            Product::whereIn('id', $ids)->each(function($product) {
                $product->delete();
            });
            $request->request->remove('product');

            $products = $query
                ->paginate(10)
                ->withQueryString();

            return back()
                ->with('products', $products)
                ->with('status', __('Products deleted!'));
        }

        if ($request->filled('search')) {
            $q = $request->query('search');
            $query->where('name', 'LIKE', '%'.$q.'%');
        }

        if ($request->filled(['order', 'orderby'])) {
            $order = $request->query('order');
            $orderby = $request->query('orderby');
            $query->orderBy($orderby, $order);
        }

        $products = $query
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->safe()->all();
        $product->update($validated);

        return back()
            ->with('status', __('Product updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', __('Product deleted!'));
    }
}
