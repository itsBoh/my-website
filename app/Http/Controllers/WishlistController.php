<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function show()
    {
        $ID = session('customer')->CUST_ID;
        $results = DB::select('SELECT P.PROD_NAME, CP.CART_QTY, P.PROD_PRICE, (CP.CART_QTY * P.PROD_PRICE) AS PRICE, CP.CART_ID, P.PROD_ID
                      FROM CART_PRODUCT CP
                      LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
                      LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
                      WHERE C.CUST_ID = ?', [$ID]);

        $wishlists = DB::select('SELECT P.PROD_NAME AS `NAME`, P.PROD_PRICE AS `PRICE`, P.PROD_ID AS `ID`, W.WISHLIST_ID AS `WISHLIST_ID`, P.PROD_STOCK AS STOCK
                    FROM WISHLIST_PRODUCT WP
                    LEFT JOIN PRODUCT P
                    ON WP.PROD_ID = P.PROD_ID
                    LEFT JOIN WISHLIST W
                    ON W.WISHLIST_ID = WP.WISHLIST_ID
                    WHERE W.CUST_ID = ?;', [$ID]);

        $total = DB::select('SELECT SUM(CP.CART_QTY * P.PROD_PRICE) AS PRICE
        FROM CART_PRODUCT CP
        LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
        WHERE C.CUST_ID = ?', [$ID]);

        #check if PROD_STOCK is > 0
        $query = 'SELECT PROD_STOCK FROM PRODUCT WHERE PROD_ID = ?';

        return view('wishlists', compact('results', 'wishlists', 'total'));
    }
    public function addToCart(Request $request)
    {
        #add wishlist to cart
        $id = session('customer')->CUST_ID;
        $prodid = request('id');
        $wishlistid = request('wishid');
        #update cart_product
        $query = 'SELECT * FROM CART_PRODUCT WHERE PROD_ID = ? AND CART_ID = (SELECT CART_ID FROM CART WHERE CUST_ID = ?)';
        $cart_product = DB::select($query, [$prodid, $id]);
        if (empty($cart_product)) {
            $query = 'INSERT INTO CART_PRODUCT (CART_ID, PROD_ID, CART_QTY) VALUES ((SELECT CART_ID FROM CART WHERE CUST_ID = ?), ?, 1)';
            DB::insert($query, [$id, $prodid]);
        } else {
            $query = 'UPDATE CART_PRODUCT SET CART_QTY = CART_QTY + 1 WHERE PROD_ID = ? AND CART_ID = (SELECT CART_ID FROM CART WHERE CUST_ID = ?)';
            DB::update($query, [$prodid, $id]);
        }
        #delete wishlist_product
        $query = 'DELETE FROM WISHLIST_PRODUCT WHERE PROD_ID = ? AND WISHLIST_ID = ?';
        DB::delete($query, [$prodid, $wishlistid]);

        return redirect()->route('wishlists');
    }
    public function removeWishlist(Request $request)
    {
        $id = session('customer')->CUST_ID;
        $prodid = request('id');
        $wishlistid = request('wishid');
        #delete wishlist_product
        $query = 'DELETE FROM wishlist_product WHERE PROD_ID = ? AND WISHLIST_ID = ?';
        DB::delete($query, [$prodid, $wishlistid]);

        return redirect()->route('wishlists');
    }
}
