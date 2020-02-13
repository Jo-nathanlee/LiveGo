<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    public $table = 'shop_product';

    protected $fillable = [
        'page_id', 'goods_name', 'goods_price', 'goods_num','category', 'description', 'pic_url', 'selling_num' , 'is_active' , 'product_id'
    ];
}
