<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CheckoutOrder extends Model
{
    public $table = 'checkout_order';

    protected $fillable = [
        'page_id', 'order_id', 'fb_id', 'name', 'goods_name', 'goods_price', 'goods_num','total_price', 'order_status', 'created_time',
    ];
}
