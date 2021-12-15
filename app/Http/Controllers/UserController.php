<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function addAddressForm(Request $request)
    {
        return view('user/add-address');
    }

    public function addAddress(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zipcode' => 'required|numeric|integer',
        ]);
        $address = Address::create([
            'shipping_name' => $request->shipping_name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('account')->with('status', 'Address added!');
    }

    public function updateAddress(Request $request) {
        $validated = $request->validate([
            'shipping_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zipcode' => 'required|numeric|integer',
        ]);
        $address = Address::find($request->id);
        $address->shipping_name = $request->shipping_name;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->country = $request->country;
        $address->zipcode = $request->zipcode;
        $address->save();
        return redirect()->route('account')->with('status', 'Address updated!');
    }

    public function deleteAddress(Request $request)
    {
        $address = Address::find($request->id);
        $address->delete();
        return redirect()->route('account')->with('status', 'Address deleted!');
    }

    public function account(Request $request)
    {
        $user = Auth::user();
        $addresses = $user->addresses;
        $orders = $user->orders;
        
        return view('user/account', [
            "addresses" => $addresses,
            "orders" => $orders
        ]);
    }

    public function orderDetails(Request $request) {
        $order = Order::find($request->id);
        return view('user/order-details', [
            "order" => $order,
        ]);
    }
}
