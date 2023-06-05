<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $table = 'cart_product';
    protected $fillable = [
        'CART_ID',
        'PROD_ID',
        'CART_QTY'
    ];
}
