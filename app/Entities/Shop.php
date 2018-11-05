<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public $table = 'shop';

    protected $fillable = [
        'page_id', 'goods_name', 'goods_price', 'goods_num','category', 'description', 'pic_url',
    ];
}
