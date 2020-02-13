<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $table = 'page';

    protected $fillable = [
        'ps_id', 'name', 'page_id', 'page_name',  'page_token',
    ];
}
