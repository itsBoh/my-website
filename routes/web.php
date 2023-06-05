<?php

use App\Http\Controllers\AccController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\checkoutController;
use App\Http\Controllers\displayCartProducts;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/about', function () {
    return view('about');
});
Route::get('account-password', function () {
    return view('account-password');
});
Route::get('account-profile', function () {
    return view('account-profile');
});
Route::get('account-transaction', function () {
    return view('account-transaction');
});
Route::get('contact', function () {
    return view('contact');
});
Route::get('Forgot-Password', function () {
    return view('Forgot-Password');
});
Route::get('product-detail', function () {
    return view('product-detail');
});
Route::get('product', function () {
    return view('product');
});
Route::get('Registrasi', function () {
    return view('Registrasi');
});
Route::get('shopping-cart', function () {
    return view('shopping-cart');
});
Route::get('wishlists', function () {
    return view('wishlists');
});
Route::get('shopping-checkout', function () {
    return view('shopping-checkout');
});
Route::get('Terms-of-Service', function () {
    return view('Terms-of-Service');
});
Route::get('main', function () {
    return view('main');
});
Route::get('paid', function () {
    return view('paid');
});

Route::get('/registration', [CustomAuthController::class, 'registration']);
Route::post('/register-user', [CustomAuthController::class, 'registerUser'])->name('register-user');
Route::get('/data', 'App\Http\Controllers\displayCust@index');
Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomAuthController::class, 'loginUser'])->name('login-user');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/cart', [CartController::class, 'show'])->name('cart-shopping')->middleware('auth');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/checkouts', [CartController::class, 'checkout'])->name('cart-checkout')->middleware('auth');
Route::post('/cart/ipdateWishlist', [CartController::class, 'updateWishlist'])->name('cart.updateWishlist');


Route::get('/index', [HomeController::class, 'index'])->name('main');
Route::get('/', [HomeController::class, 'index'])->name('main');

Route::get('/product/detail', [ProductController::class, 'detail'])->name('product-detail');
Route::match(['get', 'post'], '/product/detail', [ProductController::class, 'detail'])->name('product-detail');
Route::post('/product/wishlist', [ProductController::class, 'wishlist'])->name('product-wishlist')->middleware('auth');
Route::post('/product/cart', [ProductController::class, 'cart'])->name('product-cart')->middleware('auth');
Route::post('/product/detail', [ProductController::class, 'detail'])->name('product-detail');

Route::get('/wishlists', [WishlistController::class, 'show'])->name('wishlists')->middleware('auth');
Route::post('/wishlists/remove', [WishlistController::class, 'removeWishlist'])->name('wishlist.remove')->middleware('auth');
Route::post('/wishlists/addToCart', [WishlistController::class, 'addToCart'])->name('wishlist.addToCart')->middleware('auth');
Route::post('/product/addToWishlist', [ProductController::class, 'addToWishlist'])->name('product.addToWishlist')->middleware('auth');


Route::get('/account/profile', [AccController::class, 'show'])->name('account-profile')->middleware('auth');
Route::post('/account/update', [AccController::class, 'update'])->name('account-update')->middleware('auth');
Route::get('/account/transaction', [AccController::class, 'showTransaction'])->name('account-transaction')->middleware('auth');
Route::get('/account/password', [AccController::class, 'showPassword'])->name('account-password')->middleware('auth');
Route::post('/account/password', [AccController::class, 'changePassword'])->name('change-password')->middleware('auth');

Route::post('checkout/payment', [checkoutController::class, 'payment'])->name('checkout.payment')->middleware('auth');

Route::post('/checkout/pay', [CartController::class, 'checkout'])->name('checkout.pay')->middleware('auth');

Route::post('/checkout/finish', [checkoutController::class, 'finish'])->name('checkout.finish')->middleware('auth');