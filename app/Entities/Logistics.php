<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Logistics extends Model
{
    public $table = 'logistics';

    protected $fillable = [
        'type', 'vender', 'status_code', 'message','orderstatus_id','id'
    ];
}