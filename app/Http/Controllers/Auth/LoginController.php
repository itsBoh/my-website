<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;


// class LoginController extends Controller
// {
//     use AuthenticatesUsers;
//     protected function guard()
//     {
//         return Auth::guard('web');
//     }

//     public function showLoginForm()
//     {
//         return view('login');
//     }

//     public function login(Request $request)
//     {
//         $credentials = $request->validate([
//             'username' => 'required',
//             'password' => 'required',
//         ]);

//         if ($this->guard()->attempt($credentials)) {
//             // Authentication passed
//             return redirect()->route('index')->with('success', 'Login successful!');
//         }

//         // Authentication failed
//         return back()->withErrors(['username' => 'Invalid credentials']);
//     }
// } 
// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Http\Request;

// class LoginController extends Controller
// {
//     use AuthenticatesUsers;

//     /**
//      * Where to redirect users after login.
//      *
//      * @var string
//      */
//     protected $redirectTo = '/index';

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }

//     /**
//      * Get the login username to be used by the controller.
//      *
//      * @return string
//      */
//     public function username()
//     {
//         return 'cust_username';
//     }

//     /**
//      * Attempt to log the user into the application.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return bool
//      */
//     protected function attemptLogin(Request $request)
//     {
//         return $this->guard()->attempt(
//             $this->credentials($request),
//             $request->filled('remember')
//         );
//     }

//     /**
//      * Get the needed authorization credentials from the request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return array
//      */
//     protected function credentials(Request $request)
//     {
//         return $request->only($this->username(), 'cust_password');
//     }

//     /**
//      * The user has been authenticated.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  mixed  $user
//      * @return mixed
//      */
//     protected function authenticated(Request $request, $user)
//     {
//         // Flash a success message to the session
//         return redirect()->intended('/home')->with('success', 'Login successful!');

//     }
// }

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the user's input
        $credentials = $request->validate([
            'CUST_USERNAME' => 'required',
            'CUST_PASSWORD' => 'required',
        ]);

        // Attempt to authenticate the user
        if (auth()->attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/index');
        } else {
            // Authentication failed
            return redirect()->back()->withErrors([
                'CUST_USERNAME' => 'Invalid credentials.',
            ]);
        }
    }
}



?>