<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Trans extends Controller
{
    public function check(Request $request)
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

        DB::insert('INSERT INTO `TRANSACTION`(TRANS_ID, CUST_ID, TRANS_DATE, TRANS_TOTAL_PRICE, SHIPPING_ADDRESS, PAYMENT_METHOD, PAYMENT_STATUS, STATUS_DEL)
                      VALUES (1, ?,?,?,?,?,?,0)', [$id, $transDate, $transTotalPrice, $shippingAddress, 'CARD', 'U']);
        

        // Retrieve the cart products for the customer
        $cartProducts = DB::table('CART_PRODUCT')
            ->join('CART', 'CART_PRODUCT.CART_ID', '=', 'CART.CART_ID')
            ->where('CART.CUST_ID', $id)
            ->select('CART_PRODUCT.PROD_ID', 'CART_PRODUCT.CART_QTY')
            ->get();

        // Generate the transaction ID
        $transId = DB::select('SELECT TRANS_ID FROM TRANSACTION WHERE CUST_ID = ? ORDER BY 1 DESC', [$id]);
        $transId = $transId[0]->TRANS_ID;
        // Move the cart products to transaction products
        foreach ($cartProducts as $cartProduct) {
            $prodId = $cartProduct->PROD_ID;
            $transQty = $cartProduct->CART_QTY;
            $transPrice = DB::table('PRODUCT')
                ->where('PROD_ID', $prodId)
                ->value('PROD_PRICE');
            $transPrice = $transPrice * $transQty;
        
            // Get the current stock quantity of the product
            $currentStock = DB::table('PRODUCT')
                ->where('PROD_ID', $prodId)
                ->value('PROD_STOCK');
        
            // Calculate the new stock quantity after deducting the transaction quantity
            $newStock = $currentStock - $transQty;
        
            // Update the product quantity in the product table
            DB::table('PRODUCT')
                ->where('PROD_ID', $prodId)
                ->update(['PROD_STOCK' => $newStock]);
        
            // Insert the transaction product record
            DB::table('transaction_product')->insert([
                'PROD_ID' => $prodId,
                'TRANS_ID' => $transId,
                'TRANS_QTY' => $transQty,
                'TRANS_PRICE' => $transPrice,
                'STATUS_DEL' => 0, // Assuming 0 represents not deleted
            ]);
        }
        

        // Clear the cart for the customer
        DB::table('cart_product')->where('CART_ID', $cartId)->delete();


        $name = $name[0]->CUST_NAME;
        $total = $request->input('total');
        $date = $transDate;

        return view('paid', compact('name', 'total', 'date'));
    }
}