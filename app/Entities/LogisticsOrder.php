<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class LogisticsOrder extends Model
{
    public $table = 'logistics_order';

    protected $fillable = [
        'order_id', 'MerchantID', 'AllPayLogisticsID', 'CVSPaymentNo','CVSValidationNo','LogisticsSubType'
    ];
}