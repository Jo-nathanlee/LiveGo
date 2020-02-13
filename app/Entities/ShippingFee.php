<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    public $table = 'shipping_fee';

    protected $fillable = [
        'page_id','ship_id','fee','free_shipping','sender_phone','sender_address','sender_name'
    ];
}