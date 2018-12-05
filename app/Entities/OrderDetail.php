<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $table = 'order_detail';

    protected $fillable = [
        'page_id', 'page_name', 'buyer_fbid','buyer_fbname', 'buyer_name', 'order_id', 'transaction_date', 'status','freight',
         'all_total','goods_total', 'buyer_address','buyer_phone','note','delivery_type'
    ];
}