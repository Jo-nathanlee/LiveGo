<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    public $table = 'pay_method';

    protected $fillable = [
        'page_id', 'pay_id', 'is_active'
    ];
}