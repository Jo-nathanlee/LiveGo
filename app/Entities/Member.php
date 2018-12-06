<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $table = 'member';

    protected $fillable = [
        'fb_id', 'fb_name', 'page_id', 'page_name', 'bid_times', 'checkout_times','blacklist_times','last_buying_time'
    ];
}