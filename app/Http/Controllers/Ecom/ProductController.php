<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with('collections')
           ->where(function($q) {
                $q->where('stock', '>', 0)
                ->whereHas('productVariants', fn($q) => $q->where('stock', '>', 0)->where('is_active', true));
            });

        if ($request->min_price || $request->max_price) {
            $query->whereBetween('price', [$request->min_price ?? 0, $request->max_price ?? 99999]);
        }

        if ($request->input('sizes')) {
            $query->whereHas('productVariants', fn($q) => $q->whereIn('size', $request->input('sizes'))->where('stock', '>', 0)->where('is_active', true));
        }

        if ($request->input('capacities')) {
            $query->whereHas('productVariants', fn($q) => $q->whereIn('capacity', $request->input('capacities'))->where('stock', '>', 0)->where('is_active', true));
        }

        if ($request->input('colors')) {
            $query->whereHas('productVariants', fn($q) => $q->whereIn('color', $request->input('colors'))->where('stock', '>', 0)->where('is_active', true));
        }

        return response()->json($query->paginate(6));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::with([
            'productVariants' => function($query) {
                $query->where('is_active', true)->select('id', 'product_id', 'color', 'size', 'capacity', 'price', 'stock');
            },
            'collections'
        ])->where('slug', $slug)->firstOrFail();

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
