<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class checkoutController extends Controller
{
    public function payment(Request $request)
    {
        $cartId = $request->input('cartid');
        $id = session('customer')->CUST_ID;
        $payment_method = "card";
        $payment_status = "unpaid";
        $shipping_address = $request->input('address');
        $status_del = 0;
        # total price
        $total = DB::select('SELECT SUM(CP.CART_QTY * P.PROD_PRICE) AS PRICE
        FROM CART_PRODUCT CP
        LEFT JOIN CART C ON C.CART_ID = CP.CART_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = CP.PROD_ID
        WHERE C.CUST_ID = ?', [$id]);
        $total = $total[0]->Price;
        # shipping address

        # create new transaction with date YYYY-MM-DD
        $query = "INSERT INTO TRANSACTION(TRANS_ID, CUST_ID, TRANS_DATE, TRANS_TOTAL_PRICE, SHIPPING_ADDRESS, PAYMENT_METHOD, PAYMENT_STATUS, STATUS_DEL)
        VALUES (NULL, ?, CURDATE(), ?, ?, ?, ?, ?)";
        DB::statement($query, [$id, $total, $shipping_address, $payment_method, $payment_status, $status_del]);
        # get transaction id
        $transId = DB::select('SELECT * FROM TRANSACTION ORDER BY TRANS_ID DESC LIMIT 1;');


        # move product from cart_product to transaction_product
        $cartProducts = DB::table('cart_product')
            ->where('CART_ID', $cartId)
            ->get();

        // Iterate over the cart products and move them to the transaction_product table
        foreach ($cartProducts as $cartProduct) {
            $prodId = $cartProduct->PROD_ID;
            $cartQty = $cartProduct->CART_QTY;
            $transQty = $cartQty; // Assuming TRANS_QTY is the same as CART_QTY

            // Retrieve the product price from the product table
            $product = DB::table('product')
                ->where('PROD_ID', $prodId)
                ->first();

            // Calculate the TRANS_PRICE based on TRANS_QTY and PROD_PRICE
            $transPrice = $transQty * $product->PROD_PRICE;

            $statusDel = '0'; // Assuming STATUS_DEL is always 0

            // Insert the product into the transaction_product table
            DB::table('transaction_product')->insert([
                'PROD_ID' => $prodId,
                'TRANS_ID' => $transId,
                'TRANS_QTY' => $transQty,
                'TRANS_PRICE' => $transPrice,
                'STATUS_DEL' => $statusDel
            ]);
        }

        // Remove the products from the cart_product table
        DB::table('cart_product')
            ->where('CART_ID', $cartId)
            ->delete();

        return redirect('/')->with('success', 'Payment successful!');
    }
    public function finish(Request $request)
    {
        $id = session('customer')->CUST_ID;
        $cartId = $request->input('cartid');
        $transDate = date('Y-m-d');
        $transTotalPrice = $request->input('total');
        $shippingAddress = $request->input('address');
        $paymentMethod = "card";
        $paymentStatus = "U";
        $statusDel = 0;
        $name = DB::select('SELECT CUST_NAME FROM CUSTOMER WHERE CUST_ID = ?', [$id]);

        // add to table transaction and get the new id
        $query = "INSERT INTO ORDER2(CUST_ID, TRANS_DATE, TRANS_TOTAL_PRICE, SHIPPING_ADDRESS, PAYMENT_METHOD, PAYMENT_STATUS, STATUS_DEL) 
        VALUES(?, ?, ?, ?, ?, ?, ?)";
        DB::insert($query, [$id, $transDate, $transTotalPrice, $shippingAddress, $paymentMethod, $paymentStatus, $statusDel]);



        // delete cart_product
        // DB::table('cart_product')
        //     ->where('CART_ID', $cartId)
        //     ->delete();

        $name = $name[0]->CUST_NAME;
        $total = $request->input('total');
        $date = $transDate;

        return view('paid', compact('name', 'total', 'date'));
    }
}