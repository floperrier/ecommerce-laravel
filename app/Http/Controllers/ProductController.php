<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
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
}