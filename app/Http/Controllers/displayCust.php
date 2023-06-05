<?php

namespace App\Http\Controllers;
use App\Models\Customer;

use Illuminate\Http\Request;

class displayCust extends Controller
{
    public function index(){
        $data = Customer::all();
        return view('displayCust',compact('data'));
    }
    public function logedin(){
        return view('index');
    }
}