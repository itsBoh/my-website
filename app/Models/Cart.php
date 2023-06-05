<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class, 'CART_ID', 'CART_ID');
    }
}