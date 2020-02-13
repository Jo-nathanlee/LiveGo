<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UpdateUser extends Model
{
    public $table = 'user';

    protected $fillable = [
        'fb_id', 'ps_id', 'name', 'token'
    ];
}
