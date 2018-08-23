<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    public $table = 'shop_order';

    protected $fillable = [
        'page_id','page_name', 'fb_id', 'name', 'goods_name', 'goods_price', 'goods_num','total_price', 'order_id', 'created_time',
    ];
}
