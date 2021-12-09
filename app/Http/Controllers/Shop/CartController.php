<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use PhpParser\Node\Name\Relative;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        $product = Product::find($request->id);

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'attributes' => array(),
            'associatedModel' => 'App\Models\Product'
        ]);
        return redirect()->route('cart.index');
    }

    public function index()
    {
        $items = Cart::getContent();
        $total = Cart::getTotal();
        return view('cart/index', [
            "items" => $items,
            "totalPrice" => $total
        ]);
    }

    public function remove(Request $request)
    {
        Cart::remove($request->id);
        return redirect()->route('cart.index');
    }

    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer'
        ]);
        if ($request->quantity < 1) return redirect()->route('cart.remove', ['id' => $request->id]);
        Cart::update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ]
        ]);
        return redirect()->route('cart.index');
    }
}
