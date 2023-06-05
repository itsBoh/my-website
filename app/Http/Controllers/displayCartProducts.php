<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\Customer;

class displayCartProducts extends Controller
{
    public function getCartData()
    {
        $custId = session('CUST_ID');
        
        $cart = Cart::where('CUST_ID', $custId)->with('cartProducts.product')->first();
        
        return $cart;
    }
}