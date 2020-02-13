<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CheckoutOrder extends Model
{
    public $table = 'checkout_order';

    protected $fillable = [
        'page_id', 'order_id', 'fb_id', 'goods_num','total_price', 'created_time','product_id'
    ];
}
