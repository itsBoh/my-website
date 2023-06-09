<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class CustomAuthController extends Controller
{
    //
    public function login()
    {
        return view("login");
    }
    public function registration()
    {
        return view("Registrasi");
    }
    public function registerUser(Request $request)
    {
        $query = "INSERT INTO customer(CUST_ID, CUST_NAME, CUST_PASSWORD, CUST_EMAIL, CUST_USERNAME, CUST_PHONE, CUST_ADDRESS, CUST_GENDER,STATUS_DEL) VALUES (1,?,?,?,?,?,?,?,0)";
        $name = $request->input('CUST_NAME');
        $password = $request->input('CUST_PASSWORD');
        $email = $request->input('CUST_EMAIL');
        $username = $request->input('CUST_USERNAME');
        $phone = $request->input('cust_phone');
        $address = $request->input('CUST_ADDRESS');
        $gender = $request->input('CUST_GENDER');
        DB::insert($query, [$name, $password, $email, $username, $phone, $address, $gender]);
        // $data = $request->only(['CUST_ID','CUST_NAME','CUST_PASSWORD','CUST_EMAIL','CUST_USERNAME','cust_phone','CUST_ADDRESS','CUST_GENDER']);
        // customer::create($data);
        return view('login');
    }
    public function loginUser(Request $request)
    {
        $data = $request->only(['CUST_USERNAME', 'CUST_PASSWORD', 'remember']);
        $user = customer::where('CUST_USERNAME', $data['CUST_USERNAME'])->first();

        if ($user) {
            if ($user->CUST_PASSWORD == $data['CUST_PASSWORD']) {
                $rememberMe = isset($data['remember']) && $data['remember'] == 'On';

                // Set session timeout based on remember me selection
                $sessionTimeout = $rememberMe ? config('session.remember_me_timeout') : config('session.timeout');
                Session::put('customer', $user);
                Session::put('timeout', time() + $sessionTimeout);

                // Check if remember me is selected
                if ($rememberMe) {
                    $rememberToken = Str::random(60); // Generate a random remember token

                    DB::table('customer')
                        ->where('CUST_USERNAME', $data['CUST_USERNAME'])
                        ->update(['remember_token' => $rememberToken]);

                    // Create a remember me cookie
                    //Cookie::queue('remember_token', $rememberToken, 60 * 24 * 7); // Cookie will expire in 7 days
                    Cookie::queue('remember_token', $rememberToken, 2); // Cookie will expire in 2 minutes
                }
                return redirect()->route('main');

                 
            } else {
                return view('login')->with('error', 'Invalid username or password');
            }
        } else {
            return view('login')->with('error', 'Invalid username or password');
        }
    }
}
