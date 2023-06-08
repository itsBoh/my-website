<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\displayCartProducts;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::inRandomOrder()->limit(8)->get();

        if (session('customer')) {
            $ID = session('customer')->CUST_ID;
            $results = DB::select('SELECT P.PROD_NAME, CP.CART_QTY, P.PROD_PRICE, (CP.CART_QTY * P.PROD_PRICE) AS PRICE, CP.CART_ID, P.PROD_ID
            FROM CART_PRODUCT CP
            LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
            LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
            WHERE C.CUST_ID = ?', [$ID]);

            $wishlists = DB::SELECT('SELECT P.PROD_NAME AS NAME, P.PROD_PRICE AS PRICE, P.PROD_ID AS ID
            FROM WISHLIST_PRODUCT WP
            LEFT JOIN PRODUCT P
            ON WP.PROD_ID = P.PROD_ID
            LEFT JOIN WISHLIST W
            ON W.WISHLIST_ID = WP.WISHLIST_ID
            WHERE W.CUST_ID = ?;', [$ID]);

            $total = DB::SELECT('SELECT SUM(CP.CART_QTY * P.PROD_PRICE) AS PRICE
            FROM CART_PRODUCT CP
            LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
            LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
            WHERE C.CUST_ID = ?', [$ID]);

            return view('main', compact('results', 'wishlists', 'total', 'products'));
        } else {
            return view('main', compact('products'));
        }
    }
}