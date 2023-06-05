<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\displayCartProducts;
use Illuminate\Support\Facades\DB;

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
        if (session('customer')) {
            $id = session('customer')->CUST_ID;
            $results = DB::select('SELECT p.PROD_NAME, cp.CART_QTY, p.PROD_PRICE, (cp.CART_QTY * p.PROD_PRICE) AS Price, cp.CART_ID, p.PROD_ID
                          FROM cart_product cp
                          LEFT JOIN cart c ON c.cart_id = cp.cart_id
                          LEFT JOIN product p ON p.prod_id = cp.prod_id
                          WHERE c.cust_id = ?', [$id]);

            $wishlists = DB::select('SELECT p.PROD_NAME, p.PROD_PRICE, p.PROD_ID
                        FROM wishlist_product wp
                        left join product p
                        on wp.PROD_ID = p.PROD_ID
                        left join wishlist w
                        on w.WISHLIST_ID = wp.WISHLIST_ID
                        where w.CUST_ID = ?;', [$id]);

            $total = DB::select('SELECT sum(cp.CART_QTY * p.PROD_PRICE) AS Price
                        FROM cart_product cp
                        LEFT JOIN cart c ON c.cart_id = cp.cart_id
                        LEFT JOIN product p ON p.prod_id = cp.prod_id
                        WHERE c.cust_id = ?', [$id]);

            return view('main', compact('results', 'wishlists', 'total'));
        } else {
            return view('main');
        }
    }
}
