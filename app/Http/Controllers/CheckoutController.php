<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function billingPortal(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('checkout'));
    }

    public function checkoutForm(Request $request)
    {
        $items = Cart::getContent();
        foreach($items as $item) {
            dump($item);
        }
        $addresses = Auth::user()->addresses;
        return view('cart/checkout-form', [
            'addresses' => $addresses
        ]);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'cardHolderName' => 'required',
            'address' => 'required',
        ]);
        $address = Address::find($request->address);
        $user = Auth::user();
        $paymentAmount = (int)(Cart::getTotal() * 100);

            /* $stripeCustomer = $user->getStripeCustomer();
        dd($stripeCustomer) */;

        try {
            $stripeCharge = $user->charge(
                $paymentAmount,
                $request->paymentMethodId
            );
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->user_address_id = $address->id;
        $order->status = 'paid';
        $order->total = Cart::getTotal();
        $order->save();

        $items = Cart::getContent();
        foreach($items as $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $item->id;
            $orderDetail->quantity = $item->quantity;
            $orderDetail->save();
        }
        Cart::clear();

        return view('cart/order-confirm', [
            'order' => $order,
            'payment' => $stripeCharge
        ]);
    }
}
