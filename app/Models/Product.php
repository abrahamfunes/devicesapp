<?php

namespace App\Models;

use App\Models\ProductsItem;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Product
 * @package App\Models
 * @version October 31, 2016, 6:31 am UTC
 */
class Product extends BaseModel {

    public $timestamps = false;

    public $table = 'products';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    protected $fillable = [
        'user_id',
        'range_id',
        'model_id',
        'operating_system_id',
        'warantee_id',
        'country_id',
        'processor',
        'memory',
        'storage',
        'description1',
        'description2',
        'total',
        'showinhome',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                  => 'integer',
        'user_id'             => 'integer',
        'range_id'            => 'integer',
        'model_id'            => 'integer',
        'operating_system_id' => 'integer',
        'warantee_id'         => 'integer',
        'country_id'          => 'integer',
        'processor'           => 'string',
        'memory'              => 'string',
        'storage'             => 'string',
        'description1'        => 'string',
        'description2'        => 'string',
        'status_id'           => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function operatingSystem()
    {
        return $this->belongsTo(OperatingSystem::class);
    }

    public function productsItems()
    {
        return $this->hasMany(ProductsItem::class);
    }

    public function productsFiles()
    {
        return $this->hasMany(File::class, 'reference_id')->where(['reference_type' => 'product', 'status_id' => 1]);
    }

    public function productsGallery()
    {
        return $this->hasMany(File::class, 'reference_id')->where(['reference_type' => 'product', 'status_id' => 1, 'category_id' => 3]);
    }

}
