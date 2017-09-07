<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsItemsType
 */
class ProductsItemsType extends Model
{
    protected $table = 'products_items_types';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

        
}