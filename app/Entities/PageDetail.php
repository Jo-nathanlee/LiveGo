<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PageDetail extends Model
{
    public $table = 'page_detail';

    protected $fillable = [
        'page_id','page_name','page_token', 'deadline_time', 'freight', 'company_address','company_phone'
    ];
}