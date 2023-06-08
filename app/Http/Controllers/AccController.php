<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccController extends Controller
{
    public function show()
    {
        $id = session('customer')->CUST_ID;
        $customer = DB::select('SELECT * FROM CUSTOMER WHERE CUST_ID = ?', [$id]);

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
        $duplicateUsername = DB::select('SELECT * FROM CUSTOMER WHERE CUST_USERNAME = ? AND CUST_ID != ?', [$username, $userId]);
        if ($duplicateUsername) {
            // Handle duplicate username error
            return redirect()->back()->withErrors(['username' => 'Username is already taken.']);
        }

        // Update user profile
        $query = 'UPDATE CUSTOMER SET CUST_USERNAME = ?, CUST_NAME = ?, CUST_GENDER = ?, CUST_EMAIL = ?, CUST_ADDRESS = ?, CUST_PHONE = ? WHERE CUST_ID = ?';
        DB::statement($query, [$username, $name, $gender, $email, $address, $phone, $userId]);

        // Redirect to profile page with success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function showTransaction()
    {

        $id = session('customer')->CUST_ID;
        $customer = DB::select('SELECT * FROM CUSTOMER WHERE CUST_ID = ?', [$id]);
        $query = "SELECT P.PROD_NAME AS `NAME`, P.PROD_ID AS `ID`, TP.TRANS_QTY AS `QUANTITY`, TP.TRANS_PRICE AS `PRICE`, T.PAYMENT_STATUS AS `PAY`, DATE_FORMAT(T.TRANS_DATE, '%d-%M-%Y') AS DATE
        FROM TRANSACTION_PRODUCT TP
        LEFT JOIN TRANSACTION T ON T.TRANS_ID = TP.TRANS_ID
        LEFT JOIN PRODUCT P ON P.PROD_ID = TP.PROD_ID
        WHERE T.CUST_ID = ?;";
        $trans = DB::select($query, [$id]);

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
        WHERE C.CUST_ID = ?;', [$id]);

        return view('account-transaction', compact('trans', 'results', 'wishlists', 'total', 'customer'));
    }
    public function showPassword()
    {
        $id = session('customer')->CUST_ID;
        $customer = DB::select('SELECT * FROM CUSTOMER WHERE CUST_ID = ?', [$id]);
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
        return view('acc-password', compact('results', 'wishlists', 'total', 'customer'));
    }
    public function changePassword(Request $request)
    {

        $id = session('customer')->CUST_ID;
        $query = 'SELECT CUST_PASSWORD FROM CUSTOMER WHERE CUST_ID = ?';
        $customer = DB::select($query, [$id])[0]->CUST_PASSWORD;
        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');

        if ($oldPassword === $customer) {
            if ($newPassword === $confirmPassword) {
                DB::update('UPDATE CUSTOMER SET CUST_PASSWORD = ? WHERE CUST_ID = ?', [$newPassword, $id]);

                return redirect()->back()->with('success', 'Password changed successfully.');
            } else {
                return redirect()->back()->withErrors(['new_password' => 'New password and confirm password must match.']);
            }
        } else {
            return redirect()->back()->withErrors(['old_password' => 'Old password is incorrect.']);
        }
    }
}