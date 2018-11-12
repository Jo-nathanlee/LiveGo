<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $table = 'order_detail';

    protected $fillable = [
        'page_id', 'page_name', 'buyer_fbid', 'buyer_name', 'order_id', 'transaction_date', 'status','mac_value', 'total_price', 'buyer_address','buyer_phone'
    ];
}