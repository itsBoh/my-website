<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function show()
    {
        $id = session('customer')->CUST_ID;
        $results = DB::select('SELECT p.PROD_NAME, cp.CART_QTY, p.PROD_PRICE, (cp.CART_QTY * p.PROD_PRICE) AS Price, cp.CART_ID, p.PROD_ID
                      FROM cart_product cp
                      LEFT JOIN cart c ON c.cart_id = cp.cart_id
                      LEFT JOIN product p ON p.prod_id = cp.prod_id
                      WHERE c.cust_id = ?', [$id]);

        $wishlists = DB::select('SELECT p.PROD_NAME as `name`, p.PROD_PRICE as `price`, p.PROD_ID as `id`, w.WISHLIST_ID as `wishlist_id`, p.PROD_STOCK as `stock`
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

        #check if PROD_STOCK is > 0
        $query = 'SELECT PROD_STOCK FROM product WHERE PROD_ID = ?';

        return view('wishlists', compact('results', 'wishlists', 'total'));
    }
    public function addToCart(Request $request){
        #add wishlist to cart
        $id = session('customer')->CUST_ID;
        $prodid = request('id');
        $wishlistid = request('wishid');
        # check if product stock is > 0
        $query = 'SELECT PROD_STOCK FROM product WHERE PROD_ID = ?';
        $stock = DB::select($query, [$prodid]);
        if($stock[0]->PROD_STOCK <= 0){
            return redirect()->route('wishlists');
        }
        #update cart_product
        $query = 'SELECT * FROM cart_product WHERE PROD_ID = ? AND CART_ID = (SELECT CART_ID FROM cart WHERE CUST_ID = ?)';
        $cart_product = DB::select($query, [$prodid, $id]);
        if(empty($cart_product)){
            $query = 'INSERT INTO cart_product (CART_ID, PROD_ID, CART_QTY) VALUES ((SELECT CART_ID FROM cart WHERE CUST_ID = ?), ?, 1)';
            DB::insert($query, [$id, $prodid]);
        }else{
            $query = 'UPDATE cart_product SET CART_QTY = CART_QTY + 1 WHERE PROD_ID = ? AND CART_ID = (SELECT CART_ID FROM cart WHERE CUST_ID = ?)';
            DB::update($query, [$prodid, $id]);
        }
        #delete wishlist_product
        $query = 'DELETE FROM wishlist_product WHERE PROD_ID = ? AND WISHLIST_ID = ?';
        DB::delete($query, [$prodid, $wishlistid]);

        return redirect()->route('wishlists');
    }
    public function removeWishlist(Request $request){
        $id = session('customer')->CUST_ID;
        $prodid = request('id');
        $wishlistid = request('wishid');
        #delete wishlist_product
        $query = 'DELETE FROM wishlist_product WHERE PROD_ID = ? AND WISHLIST_ID = ?';
        DB::delete($query, [$prodid, $wishlistid]);

        return redirect()->route('wishlists');
    }
}
