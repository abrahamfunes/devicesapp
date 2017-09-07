<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class ProductsItem
 */
class ProductsItem extends BaseModel
{
    protected $table = 'products_items';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'type_id',
        'description'
    ];

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(ProductsItemsType::class);
    }

}