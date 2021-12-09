<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Shop\CartController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
