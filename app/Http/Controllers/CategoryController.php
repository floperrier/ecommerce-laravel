<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show(Request $request) {
        //$products = Product::where('active', 1)->where('category_id',$request->id)->get();
        $category = Category::find($request->id);
        if (!$category->active) {
            return redirect()->route->home();
        }
        $products = $category->products;

        return view('product/index', [
            'products' => $products
        ]);
    }
}
