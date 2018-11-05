<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    public $table = 'product_categories';

    protected $fillable = [
        'category','page_id'
    ];
}