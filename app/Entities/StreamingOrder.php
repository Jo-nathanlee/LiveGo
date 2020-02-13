<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StreamingOrder extends Model
{
    public $table = 'streaming_order';

    protected $fillable =[
        'page_id', 'ps_id', 'goods_num','bid_price', 'comment', 'order_id', 'live_video_id','product_id'
    ];

}
