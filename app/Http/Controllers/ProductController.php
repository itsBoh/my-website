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

        $query = "SELECT p.PROD_ID, p.PROD_NAME, p.PROD_PRICE,CASE WHEN wp.wishlist_id = 'W-001' THEN 'y' ELSE 'n' END AS is_in_wishlist FROM product p
                    LEFT JOIN wishlist_product wp ON p.PROD_ID = wp.PROD_ID;";
        $currentPage = $products->currentPage();

        if (session('customer')) {
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

            return view('product', compact('products', 'results', 'wishlists', 'total', 'currentPage'));
        } else {
            return view('product', compact('products', 'currentPage'));
        }
    }
    public function detail(Request $request)
    {

        $prodid = $request->input('prodid');
        $products = DB::select('SELECT * FROM product WHERE PROD_ID = ?', [$prodid]);
        if (session('customer')) {
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
        $cartid = DB::select('SELECT CART_ID FROM cart WHERE cust_id = ?', [$custid]);
        # add product to cart_product
        $query = DB::insert('INSERT INTO cart_product (CART_ID, PROD_ID, CART_QTY) VALUES (?, ?,1)', [$cartid[0]->CART_ID, $prodid]);
        #delete product from wishlist_product
        $query = DB::delete('DELETE FROM wishlist_product WHERE PROD_ID = ? AND WISHLIST_ID = ?', [$prodid, $wishlist_id]);
    }
    public function cart(Request $request)
    {
        #add to cart product based on product id
        $prodid = $request->input('prodid');
        $custid = session('customer')->CUST_ID;
        $quantity = $request->input('quantity');
        # get cart id based on customer id
        $cartid = DB::select('SELECT CART_ID FROM cart WHERE cust_id = ?', [$custid]);
        # check if stock is available
        $stock = DB::select('SELECT PROD_STOCK FROM product WHERE PROD_ID = ?', [$prodid]);
        if ($stock[0]->PROD_STOCK > 0) {
            # check if product is already in cart
            $check = DB::select('SELECT * FROM cart_product WHERE CART_ID = ? AND PROD_ID = ?', [$cartid[0]->CART_ID, $prodid]);
            if ($check) {
                # update quantity
                $query = DB::update('UPDATE cart_product SET CART_QTY = CART_QTY + ? WHERE CART_ID = ? AND PROD_ID = ?', [$quantity, $cartid[0]->CART_ID, $prodid]);
            } else {
                # add product to cart_product
                $query = DB::insert('INSERT INTO cart_product (CART_ID, PROD_ID, CART_QTY) VALUES (?, ?,?)', [$cartid[0]->CART_ID, $prodid, $quantity]);
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
        $check = DB::select('SELECT * FROM wishlist_product WHERE PROD_ID = ? AND WISHLIST_ID = ?', [$prodid, $custid]);
        if ($check) {
            #display error message
            return redirect()->route('products')->with('error', 'Product already in wishlist');
        } else {
            # get wishlist id based on customer id
            $wishlistid = DB::select('SELECT WISHLIST_ID FROM wishlist WHERE cust_id = ?', [$custid]);
            # add product to wishlist_product
            $query = DB::insert('INSERT INTO wishlist_product (WISHLIST_ID, PROD_ID) VALUES ((SELECT WISHLIST_ID FROM wishlist WHERE CUST_ID = ?) , ?)', [$custid, $prodid]);
        }
        
        #display success message
        return redirect()->route('products')->with('success', 'Product added to wishlist');
    }
}
