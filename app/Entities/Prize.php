<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    public $table = 'prize';

    protected $fillable = [
        'page_id', 'product_name','image_url','ps_id','order_id'
    ];
}