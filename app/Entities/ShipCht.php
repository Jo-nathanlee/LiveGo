<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ShipCht extends Model
{
    public $table = 'ship_cht';

    protected $fillable = [
        'ship_id', 'status_cht','value'
    ];
}