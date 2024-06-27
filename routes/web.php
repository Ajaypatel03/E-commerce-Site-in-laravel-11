<?php

use App\Http\Controllers\site\IndexController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('site.index');
// });
Route::get('/',[IndexController::class, 'openHomePage'])->name('site.homePage');

Route::get('product/{id}',[IndexController::class,'openProductDetail'])->name('site.product.details');
Route::get('cart',[IndexController::class,'openCartPage'])->name('site.cart');
Route::get('add_to_cart',[IndexController::class,'AddProductIntoCart'])->name('add_to_cart');
Route::get('checkout',[IndexController::class,'openCheckoutPage'])->name('site.checkout');

Route::get('calculate/cart_items',[IndexController::class, 'calculateCartItems'])->name('calculate.add_to_cart');