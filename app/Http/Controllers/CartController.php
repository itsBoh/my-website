<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Model;

class CartController extends Controller
{
    public function show()
    {
        // get id from session
        $id = session('customer')->CUST_ID;
        $results = DB::select('SELECT P.PROD_NAME, CP.CART_QTY, P.PROD_PRICE, (CP.CART_QTY * P.PROD_PRICE) AS PRICE, CP.CART_ID, P.PROD_ID
        FROM CART_PRODUCT CP
        LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
        WHERE C.CUST_ID = ?', [$id]);

        $wishlists = DB::select('SELECT P.PROD_NAME AS `NAME`, P.PROD_PRICE AS `PRICE`, P.PROD_ID AS `ID`, W.WISHLIST_ID AS WISHLIST_ID
        FROM WISHLIST_PRODUCT WP
        LEFT JOIN PRODUCT P
        ON WP.PROD_ID = P.PROD_ID
        LEFT JOIN WISHLIST W
        ON W.WISHLIST_ID = WP.WISHLIST_ID
        WHERE W.CUST_ID = ?;', [$id]);

        $total = DB::select('SELECT SUM(CP.CART_QTY * P.PROD_PRICE) AS PRICE
        FROM CART_PRODUCT CP
        LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
        WHERE C.CUST_ID = ?', [$id]);

        $address = DB::select('SELECT CUST_ADDRESS FROM CUSTOMER WHERE CUST_ID = ?', [$id]);

        return view('shopping-cart', compact('results', 'wishlists', 'address', 'total'));
    }
    public function updateCart(Request $request)
    {
        $quantities = $request->input('quantity');
        foreach ($quantities as $key => $quantity) {
            # delete if quantity is 0
            if ($quantity == 0) {
                $cartProductId = $request->input('cartid')[$key];
                $cartId = $request->input('cartid')[$key];
                $prodId = $request->input('prodid')[$key];

                $query = "DELETE FROM CART_PRODUCT WHERE CART_ID = ? AND PROD_ID = ?";
                DB::statement($query, [$cartId, $prodId]);
            } else{
                $cartProductId = $request->input('cartid')[$key];
                $cartId = $request->input('cartid')[$key];
                $prodId = $request->input('prodid')[$key];

                // Perform any necessary validation or checks here
                // ...

                $query = "UPDATE CART_PRODUCT SET CART_QTY = ? WHERE CART_ID = ? AND PROD_ID = ?";
                DB::statement($query, [$quantity, $cartId, $prodId]);
            }
        }

        // Redirect or return a response
        return redirect()->back()->with('success', 'Cart updated successfully');
    }
    public function checkout(Request $request)
    {
        // Perform the checkout process
        $id = session('customer')->CUST_ID;
        $address = $request->input('address');

        $result2 = DB::select('SELECT SUM(CP.CART_QTY * P.PROD_PRICE) AS PRICE
        FROM CART_PRODUCT CP
        LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
        WHERE C.CUST_ID = ?', [$id]);

        $results = DB::select('SELECT P.PROD_NAME, CP.CART_QTY, P.PROD_PRICE, (CP.CART_QTY * P.PROD_PRICE) AS PRICE, CP.CART_ID, P.PROD_ID
        FROM CART_PRODUCT CP
        LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
        WHERE C.CUST_ID = ?', [$id]);

        $wishlists = DB::select('SELECT P.PROD_NAME AS `NAME`, P.PROD_PRICE AS `PRICE`, P.PROD_ID AS `ID`, W.WISHLIST_ID AS WISHLIST_ID
        FROM WISHLIST_PRODUCT WP
        LEFT JOIN PRODUCT P
        ON WP.PROD_ID = P.PROD_ID
        LEFT JOIN WISHLIST W
        ON W.WISHLIST_ID = WP.WISHLIST_ID
        WHERE W.CUST_ID = ?;', [$id]);

        $total = DB::select('SELECT SUM(CP.CART_QTY * P.PROD_PRICE) AS PRICE
        FROM CART_PRODUCT CP
        LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
        WHERE C.CUST_ID = ?', [$id]);

        return view('shopping-checkout', compact('results', 'result2', 'wishlists', 'total', 'address'));
    }
    public function header()
    {
        $id = session('customer')->CUST_ID;
        $results = DB::select('SELECT P.PROD_NAME, CP.CART_QTY, P.PROD_PRICE, (CP.CART_QTY * P.PROD_PRICE) AS PRICE, CP.CART_ID, P.PROD_ID
        FROM CART_PRODUCT CP
        LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
        WHERE C.CUST_ID = ?', [$id]);

        return view('header', compact('results'));
    }

    public function updateWishlist(Request $request)
    {
        $userid = session('customer')->CUST_ID;
        $prodid = $request->input('prodid');
        $wishlistid = $request->input('wishlistid');
        


        // Redirect or return a response
        return redirect()->back()->with('success', 'Cart updated successfully');
    }
}