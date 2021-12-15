<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/products', [ ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ ProductController::class, 'show'])->name('product.show');

Route::get('/category/{id}', [ CategoryController::class, 'show'])->name('category.show');

Route::get('/search', [ ProductController::class, 'search'])->name('search');

Route::post('cart/add/{id}', [ CartController::class, 'add'])->name('cart.add');
Route::get('cart', [ CartController::class, 'index'])->name('cart.index');
Route::get('cart/remove/{id}', [ CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/update', [ CartController::class, 'update'])->name('cart.update');
Route::post('cart/update/{id}', [ CartController::class, 'updateQuantity'])->name('cart.update.item');

Route::get('billing-portal', [ CheckoutController::class, 'billingPortal'])->middleware('auth')->name('billingPortal');

Route::get('checkout', [ CheckoutController::class, 'checkoutForm'])->middleware('auth')->name('checkout.form');
Route::post('checkout', [ CheckoutController::class, 'checkout'])->middleware('auth')->name('checkout');

Route::get('address/add', [ UserController::class, 'addAddressForm'])->middleware('auth')->name('address.add.form');
Route::post('address/add', [ UserController::class, 'addAddress'])->middleware('auth')->name('address.add');
Route::get('address/delete/{id}', [ UserController::class, 'deleteAddress'])->middleware('auth')->name('address.delete');
Route::post('address/update/{id}', [ UserController::class, 'updateAddress'])->middleware('auth')->name('address.update');

Route::get('account', [ UserController::class, 'account'])->middleware('auth')->name('account');
Route::get('order/{id}', [ UserController::class, 'orderDetails'])->middleware('auth')->name('order.details');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
