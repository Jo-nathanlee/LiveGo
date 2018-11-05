<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StreamingProduct extends Model
{
    public $table = 'streaming_product';

    protected $fillable = [
        'page_id', 'goods_name', 'goods_price', 'goods_num', 'description', 'pic_name',
    ];
}