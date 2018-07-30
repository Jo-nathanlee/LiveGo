<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    public $table = 'shop_order';

    protected $fillable = [
        'page_id', 'fb_id', 'name', 'goods_name', 'goods_price', 'goods_num', 'order_id', 'created_time',
    ];
}
