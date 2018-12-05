<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $table = 'page';

    protected $fillable = [
        'fb_id', 'name', 'page_id', 'page_name', 'page_pic', 'page_token','page_category','freight'
    ];
}
