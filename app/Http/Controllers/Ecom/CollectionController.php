<?php

namespace App\Http\Controllers\ecom;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::where('is_active', true)->with('products')->get();
        return response()->json($collections);
    }
}
