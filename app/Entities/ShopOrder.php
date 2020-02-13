<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    public $table = 'shop_order';

    protected $fillable = [
        'page_id','fb_id', 'goods_num','total_price', 'order_id', 'created_time','uid','product_id'
    ];
}
