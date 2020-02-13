<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PageDetail extends Model
{
    public $table = 'page_detail';

    protected $fillable = [
        'page_id','sender_id','sender_phone','sender_address','sender_address_forever','sender_name','sender_email','bank_code',
        'bank_name','bank_account','bank_account_name','home_delivery','seven_eleven','ok_mart','family_mart','hi_life'
    ];
}