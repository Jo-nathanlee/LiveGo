<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $table = 'member';

    protected $fillable = [
        'ps_id','as_id', 'page_id', 'bid_times', 'checkout_times', 'cancel_times', 'last_buying_time','member_type', 'fb_name', 'money_spent'
    ];
}