<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class AuctionList extends Model
{
    public $table = 'auction_list';

    protected $fillable = [
        'live_video_id', 'product_id','page_id','is_active'
    ];
}
