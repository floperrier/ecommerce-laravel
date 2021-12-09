<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ShippingMethod;
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
            'attributes' => [
                'priceWithVAT' => $product->priceWithVAT()
            ],
            'associatedModel' => 'App\Models\Product'
        ]);
        return redirect()->route('cart.index');
    }

    public function index()
    {
        // Ajout des frais livraison
        $selectedShipping = Cart::getConditionsByType('shipping')->first();
        if (!$selectedShipping) {
            $defaultShippingMethod = ShippingMethod::active()->first();
            $selectedShipping = new \Darryldecode\Cart\CartCondition([
                'name' => $defaultShippingMethod->label,
                'type' => 'shipping',
                'target' => 'total',
                'value' => $defaultShippingMethod->price,
                'order' => 10
            ]);
            Cart::condition($selectedShipping);
        }
        // Ajout des taxes
        $vatCondition = new \Darryldecode\Cart\CartCondition([
            'name' => 'VAT 20%',
            'type' => 'tax',
            'target' => 'total',
            'value' => '+20%',
            'order' => 1
        ]);
        Cart::condition($vatCondition);

        $subTotal = Cart::getSubTotal();
        $total = Cart::getTotal();

        $vat = $vatCondition->getCalculatedValue($subTotal);
        return view('cart/index', [
            "items" => Cart::getContent(),
            "totalPrice" => number_format($total, 2),
            "subTotal" => number_format($subTotal, 2),
            "vat" => number_format($vat, 2),
            "shippingMethods" => ShippingMethod::all(),
            "selectedShipping" => $selectedShipping,
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

    public function update(Request $request)
    {
        $shipping = ShippingMethod::where('name', $request->shipping)->first();
        Cart::removeConditionsByType('shipping');
        $shippingCondition = new \Darryldecode\Cart\CartCondition([
            'name' => $shipping->label,
            'type' => 'shipping',
            'target' => 'total',
            'value' => $shipping->price,
            'order' => 10
        ]);
        Cart::condition($shippingCondition);
        return redirect()->route('cart.index');
    }
}
