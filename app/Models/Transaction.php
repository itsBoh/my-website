<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Define the table associated with the model (optional)
    protected $table = 'transaction';

    // Define the primary key column (optional)
    protected $primaryKey = 'id';

    // Define any additional columns that can be mass assignable (optional)
    protected $fillable = [
        'CUST_ID',
        'TRANS_DATE',
        'TRANS_TOTAL_PRICE',
        'SHIPPING_ADDRESS',
        'PAYMENT_METHOD',
        'PAYMENT_STATUS',
        'STATUS_DEL',
    ];

    // Disable the automatic timestamps (optional)
    public $timestamps = false;
}
