<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(8);

        $query = "SELECT P.PROD_ID, P.PROD_NAME, P.PROD_PRICE, CASE WHEN WP.WISHLIST_ID = 'W-001' THEN 'Y' ELSE 'N' END AS IS_IN_WISHLIST FROM PRODUCT P
                    LEFT JOIN WISHLIST_PRODUCT WP ON P.PROD_ID = WP.PROD_ID;";
        $currentPage = $products->currentPage();

        if (session('customer')) {
            $ID = session('customer')->CUST_ID;
            $results = DB::SELECT('SELECT P.PROD_NAME, CP.CART_QTY, P.PROD_PRICE, (CP.CART_QTY * P.PROD_PRICE) AS PRICE, CP.CART_ID, P.PROD_ID
            FROM CART_PRODUCT CP
            LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
            LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
            WHERE C.CUST_ID = ?', [$ID]);

            $wishlists = DB::SELECT('SELECT P.PROD_NAME AS NAME, P.PROD_PRICE AS PRICE, P.PROD_ID AS ID, W.WISHLIST_ID AS WISHLIST_ID, P.PROD_STOCK AS STOCK
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

            return view('product', compact('products', 'results', 'wishlists', 'total', 'currentPage'));
        } else {
            return view('product', compact('products', 'currentPage'));
        }
    }
    public function detail(Request $request)
    {

        $prodid = $request->input('prodid');
        $products = DB::SELECT('SELECT * FROM PRODUCT WHERE PROD_ID = ?', [$prodid]);
        if (session('customer')) {
            $ID = session('customer')->CUST_ID;
            $results = DB::SELECT('SELECT P.PROD_NAME, CP.CART_QTY, P.PROD_PRICE, (CP.CART_QTY * P.PROD_PRICE) AS PRICE, CP.CART_ID, P.PROD_ID
            FROM CART_PRODUCT CP
            LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
            LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
            WHERE C.CUST_ID = ?', [$ID]);

            $wishlists = DB::SELECT('SELECT P.PROD_NAME AS NAME, P.PROD_PRICE AS PRICE, P.PROD_ID AS ID, W.WISHLIST_ID AS WISHLIST_ID, P.PROD_STOCK AS STOCK
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

            return view('product-detail', compact('products', 'results', 'wishlists', 'total'));
        } else {

            return view('product-detail', compact('products'));
        }
    }
    public function wishlist(Request $request)
    {
        #add to cart product based on product id
        $prodid = $request->input('prodid');
        $custid = session('customer')->CUST_ID;
        $wishlist_id = $request->input('wishlist_id');
        # get cart id based on customer id
        $cartid = DB::SELECT('SELECT CART_ID FROM cart WHERE cust_id = ?', [$custid]);
        # add product to cart_product
        $query = DB::INSERT('INSERT INTO CART_PRODUCT (CART_ID, PROD_ID, CART_QTY) VALUES (?, ?,1)', [$cartid[0]->CART_ID, $prodid]);
        #delete product from wishlist_product
        $query = DB::DELETE('DELETE FROM WISHLIST_PRODUCT WHERE PROD_ID = ? AND WISHLIST_ID = ?', [$prodid, $wishlist_id]);
    }
    public function cart(Request $request)
    {
        #add to cart product based on product id
        $prodid = $request->input('prodid');
        $custid = session('customer')->CUST_ID;
        $quantity = $request->input('quantity');
        # get cart id based on customer id
        $cartid = DB::SELECT('SELECT CART_ID FROM cart WHERE cust_id = ?', [$custid]);
        # check if stock is available
        $stock = DB::SELECT('SELECT PROD_STOCK FROM product WHERE PROD_ID = ?', [$prodid]);
        if ($stock[0]->PROD_STOCK > 0) {
            # check if product is already in cart
            $check = DB::SELECT('SELECT * FROM cart_product WHERE CART_ID = ? AND PROD_ID = ?', [$cartid[0]->CART_ID, $prodid]);
            if ($check) {
                # update quantity
                $query = DB::UPDATE('UPDATE cart_product SET CART_QTY = CART_QTY + ? WHERE CART_ID = ? AND PROD_ID = ?', [$quantity, $cartid[0]->CART_ID, $prodid]);
            } else {
                # add product to cart_product
                $query = DB::INSERT('INSERT INTO cart_product (CART_ID, PROD_ID, CART_QTY) VALUES (?, ?,?)', [$cartid[0]->CART_ID, $prodid, $quantity]);
            }
            #display success message
            // return redirect()->route('product-detail')->with('success', 'Product added to cart')->withInput('prodid' => $prodid);
            return redirect()->route('products')->with('success', 'Product added to cart');
        } else {
            #display error message
            return  redirect()->route('products')->with('error', 'Product out of stock');
            // return redirect()->back()->with('error', 'Product out of stock');
        }
    }
    public function addToWishlist(Request $request)
    {
        #add to cart product based on product id
        $prodid = $request->input('prodid');
        $custid = session('customer')->CUST_ID;
        #check if product is already in wishlist
        $check = DB::SELECT('SELECT * FROM wishlist_product WHERE PROD_ID = ? AND WISHLIST_ID = ?', [$prodid, $custid]);
        if ($check) {
            #display error message
            return redirect()->route('products')->with('error', 'Product already in wishlist');
        } else {
            # get wishlist id based on customer id
            $wishlistid = DB::SELECT('SELECT WISHLIST_ID FROM wishlist WHERE cust_id = ?', [$custid]);
            # add product to wishlist_product
            $query = DB::INSERT('INSERT INTO wishlist_product (WISHLIST_ID, PROD_ID) VALUES ((SELECT WISHLIST_ID FROM wishlist WHERE CUST_ID = ?) , ?)', [$custid, $prodid]);
        }
        
        #display success message
        return redirect()->route('products')->with('success', 'Product added to wishlist');
    }
}