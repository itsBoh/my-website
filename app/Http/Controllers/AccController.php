<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccController extends Controller
{
    public function show()
    {
        $id = session('customer')->CUST_ID;
        $customer = DB::select('SELECT * FROM customer WHERE CUST_ID = ?', [$id]);

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

        return view('account-profile', compact('customer', 'results', 'wishlists', 'total'));
    }
    public function update(Request $request)
    {
        $userId = session('customer')->CUST_ID;
        $username = $request->input('username');
        $name = $request->input('name');
        $gender = $request->input('gender');
        $email = $request->input('email');
        $address = $request->input('address');
        $phone = $request->input('phone');

        // Check for duplicate username
        $duplicateUsername = DB::select('SELECT * FROM customer WHERE CUST_USERNAME = ? AND CUST_ID != ?', [$username, $userId]);
        if ($duplicateUsername) {
            // Handle duplicate username error
            return redirect()->back()->withErrors(['username' => 'Username is already taken.']);
        }

        // Update user profile
        $query = 'UPDATE customer SET CUST_USERNAME = ?, CUST_NAME = ?, CUST_GENDER = ?, CUST_EMAIL = ?, CUST_ADDRESS = ?, cust_phone = ? WHERE CUST_ID = ?';
        DB::statement($query, [$username, $name, $gender, $email, $address, $phone, $userId]);

        // Redirect to profile page with success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function showTransaction()
    {
        
        $id = session('customer')->CUST_ID;
        $customer = DB::select('SELECT * FROM customer WHERE CUST_ID = ?', [$id]);
        $query = "select p.PROD_NAME as name, p.PROD_ID as id, tp.TRANS_QTY as quantity, tp.TRANS_PRICE as price, t.payment_status as 'pay', date_format(t.TRANS_DATE, '%d-%M-%Y') as `date`
                    from transaction_product tp
                    left join transaction t
                    on t.trans_id = tp.trans_id
                    left join product p
                    on p.prod_id = tp.PROD_ID
                    where t.CUST_ID = ?;";
        $trans = DB::select($query, [$id]);

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

        return view('account-transaction', compact('trans', 'results', 'wishlists', 'total', 'customer'));
    }
    public function showPassword()
    {
        $id = session('customer')->CUST_ID;
        $customer = DB::select('SELECT * FROM customer WHERE CUST_ID = ?', [$id]);
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
        return view('acc-password', compact('results', 'wishlists', 'total', 'customer'));
    }
    public function changePassword(Request $request)
    {

        $id = session('customer')->CUST_ID;
        $query = 'SELECT CUST_PASSWORD FROM customer WHERE CUST_ID = ?';
        $customer = DB::select($query, [$id])[0]->CUST_PASSWORD;
        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');

        if ($oldPassword === $customer) {
            if ($newPassword === $confirmPassword) {
                DB::update('UPDATE customer SET CUST_PASSWORD = ? WHERE CUST_ID = ?', [$newPassword, $id]);

                return redirect()->back()->with('success', 'Password changed successfully.');
            } else {
                return redirect()->back()->withErrors(['new_password' => 'New password and confirm password must match.']);
            }
        } else {
            return redirect()->back()->withErrors(['old_password' => 'Old password is incorrect.']);
        }
    }
}