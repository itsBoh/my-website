<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
    public function loginUser(Request $request){
        $data = $request->only(['CUST_USERNAME','CUST_PASSWORD']);
        $user = customer::where('CUST_USERNAME', $data['CUST_USERNAME'])->first();
        if($user){
            if($user->CUST_PASSWORD == $data['CUST_PASSWORD']){
                Session::put('customer', $user);
                return redirect('');
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