<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    //
    public function login(){
        return view("login");
    }
    public function registration(){
        return view("Registrasi");
    }
    public function registerUser(Request $request){
        $data = $request->only(['CUST_NAME','CUST_PASSWORD','CUST_EMAIL','CUST_USERNAME','cust_phone','CUST_ADDRESS','CUST_GENDER']);
        customer::create($data);
        return view('login');
    }
    public function loginUser(Request $request){
        $data = $request->only(['CUST_USERNAME','CUST_PASSWORD']);
        $user = customer::where('CUST_USERNAME', $data['CUST_USERNAME'])->first();
        if($user){
            if($user->CUST_PASSWORD == $data['CUST_PASSWORD']){
                Session::put('customer', $user);
                return view('main');
            }
            else{
                return view('login');
            }
        }
        else{
            return view('login');
        }
    }
}