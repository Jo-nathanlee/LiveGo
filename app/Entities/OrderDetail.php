<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $table = 'order_detail';

    protected $fillable = [
        'id','page_id','ps_id','receiver_name','order_id','transaction_date','status','other_status','address',
        'cellphone','note','created_at','updated_at','delivery_type','pay_id','freight','goods_total','buyer_bankcode'
    ];
}