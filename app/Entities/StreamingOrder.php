<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StreamingOrder extends Model
{
    public $table = 'streaming_order';

    protected $fillable = [
        'page_id', 'fb_id', 'name', 'goods_name', 'goods_price', 'goods_num','total_price', 'note', 'comment', 'order_id', 'created_time',
    ];
}
