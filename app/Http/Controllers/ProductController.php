<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        $products = Product::search('qsdqsdqds')->get();
        return view('product/index', [
            'products' => $products
        ]);
    }

    public function show(Request $request) {
        $product = Product::find($request->id);
        return view('product/show', [
            'product' => $product
        ]);
    }

    public function search(Request $request) {
        $products = Product::search($request->search)->get();
        foreach($products as $product) {
            $product->name = str_replace($request->search, "<span class='bg-yellow-200'>$request->search</span>", $product->name);
            $product->description = str_replace($request->search, "<span class='bg-yellow-200'>$request->search</span>", $product->description);
        }
        return view('product/search', [
            'products' => $products,
            'query' => $request->search,
            'results_number' => count($products)
        ]);
    }
}