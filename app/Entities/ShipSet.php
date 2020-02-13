<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ShipSet extends Model
{
    public $table = 'ship_set';

    protected $fillable = [
        'page_id', 'ship_id', 'ship_price', 'is_active'
    ];
}