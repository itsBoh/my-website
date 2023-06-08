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
        $results = DB::select('SELECT p.PROD_NAME, cp.CART_QTY, p.PROD_PRICE, (cp.CART_QTY * p.PROD_PRICE) AS Price, cp.CART_ID, p.PROD_ID
                      FROM cart_product cp
                      LEFT JOIN cart c ON c.cart_id = cp.cart_id
                      LEFT JOIN product p ON p.prod_id = cp.prod_id
                      WHERE c.cust_id = ?', [$id]);

        $wishlists = DB::select('SELECT p.PROD_NAME as `name`, p.PROD_PRICE as `price`, p.PROD_ID as `id`, w.WISHLIST_ID as `wishlist_id`
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

        $address = DB::select('SELECT CUST_ADDRESS FROM customer WHERE CUST_ID = ?', [$id]);

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

                $query = "DELETE FROM cart_product WHERE CART_ID = ? AND PROD_ID = ?";
                DB::statement($query, [$cartId, $prodId]);
            }
            # update if stock > quantity
            elseif ($quantity <= $request->input('stock')[$key]) {
                $cartProductId = $request->input('cartid')[$key];
                $cartId = $request->input('cartid')[$key];
                $prodId = $request->input('prodid')[$key];

                // Perform any necessary validation or checks here
                // ...

                $query = "UPDATE cart_product SET CART_QTY = ? WHERE CART_ID = ? AND PROD_ID = ?";
                DB::statement($query, [$quantity, $cartId, $prodId]);
            }
            else{
                $cartProductId = $request->input('cartid')[$key];
                $cartId = $request->input('cartid')[$key];
                $prodId = $request->input('prodid')[$key];

                // Perform any necessary validation or checks here
                // ...

                $query = "UPDATE cart_product SET CART_QTY = ? WHERE CART_ID = ? AND PROD_ID = ?";
                DB::statement($query, [$quantity, $cartId, $prodId]);
            }
        }

        // Redirect or return a response
        return redirect()->back()->with('success', 'Cart updated successfully');
    }
    public function checkout(Request $request)
    {
        // check if quantity in cart_product is more than stock
        $custid = session('customer')->CUST_ID;
        $cartId = DB::select('SELECT CART_ID FROM cart WHERE CUST_ID = ?', [$custid]);
        $cartId = $cartId[0]->CART_ID;
        $cartProducts = DB::select('SELECT * FROM cart_product WHERE CART_ID = ?', [$cartId]);
        foreach ($cartProducts as $cartProduct) {
            $prodId = $cartProduct->PROD_ID;
            $prodStock = DB::select('SELECT PROD_STOCK FROM product WHERE PROD_ID = ?', [$prodId]);
            $prodStock = $prodStock[0]->PROD_STOCK;
            if ($cartProduct->CART_QTY > $prodStock) {
                return redirect()->back()->with('error', 'Quantity in cart is more than stock');
            }
        }
        
        // Perform the checkout process
        $id = session('customer')->CUST_ID;
        $address = $request->input('address');

        $result2 = DB::select('SELECT sum(cp.CART_QTY * p.PROD_PRICE) AS Price
                    FROM cart_product cp
                    LEFT JOIN cart c ON c.cart_id = cp.cart_id
                    LEFT JOIN product p ON p.prod_id = cp.prod_id
                    WHERE c.cust_id = ?', [$id]);

        $results = DB::select('SELECT p.PROD_NAME, cp.CART_QTY, p.PROD_PRICE, (cp.CART_QTY * p.PROD_PRICE) AS Price, cp.CART_ID, p.PROD_ID
                    FROM cart_product cp
                    LEFT JOIN cart c ON c.cart_id = cp.cart_id
                    LEFT JOIN product p ON p.prod_id = cp.prod_id
                    WHERE c.cust_id = ?', [$id]);

        $wishlists = DB::select('SELECT p.PROD_NAME as `name`, p.PROD_PRICE as `price`, p.PROD_ID as `id`, w.WISHLIST_ID as `wishlist_id`
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

        return view('shopping-checkout', compact('results', 'result2', 'wishlists', 'total', 'address'));
    }
    public function header()
    {
        $id = session('customer')->CUST_ID;
        $results = DB::select('SELECT p.PROD_NAME, cp.CART_QTY, p.PROD_PRICE, (cp.CART_QTY * p.PROD_PRICE) AS Price, cp.CART_ID, p.PROD_ID
                      FROM cart_product cp
                      LEFT JOIN cart c ON c.cart_id = cp.cart_id
                      LEFT JOIN product p ON p.prod_id = cp.prod_id
                      WHERE c.cust_id = ?', [$id]);

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
