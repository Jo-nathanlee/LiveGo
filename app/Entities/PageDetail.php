<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $table = 'page_detail';

    protected $fillable = [
        'page_id', 'deadline_time', 'freight', 'company_address','company_phone'
    ];
}