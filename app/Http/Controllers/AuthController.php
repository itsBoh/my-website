<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('CUST_USERNAME', 'CUST_PASSWORD');

        if (Auth::guard('web')->attempt($credentials, $request->has('remember'))) {
            // Authentication passed
            $user = Customer::where('CUST_USERNAME', $credentials['CUST_USERNAME'])->first();
            Session::put('customer', $user);
            return redirect()->route('/');
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Wrong username or password');
        }
        
    }

    public function logout()
    {
        Session::forget('customer');
        return redirect()->route('/');
    }
}
