<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

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
            return redirect()->route('main');
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Wrong username or password');
        }

    }

    public function logout()
    {
        Session::forget('customer');
        return redirect('');
    }

    // Redirect the user to the Google authentication page
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle the Google callback after authentication
    public function handleGoogleCallback()
    {
        $googleUser  = Socialite::driver('google')->user();
        // Check if the user already exists
        $existingUser = Customer::where('CUST_EMAIL', $googleUser ->email)->first();

        if ($existingUser) {
            $user = Customer::where('CUST_EMAIL', $googleUser ->email)->first();
            Session::put('customer', $user);
            return redirect()->route('main');
        } else {
            // Create a new user
            return redirect()->route('Registrasi', [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
            ]);
        }

        // Redirect to the desired page after login
        return redirect('/main');
    }
}