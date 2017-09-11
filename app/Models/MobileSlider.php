<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MobileSlider
 * @package App\Models
 * @version September 11, 2017, 5:14 pm UTC
 */
class MobileSlider extends BaseModel
{
    #use SoftDeletes;

    public $table = 'mobile_slider';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    #protected $dates = ['deleted_at'];


    public $fillable = [
        'model_id',
        'name',
        'url',
        'image',
        'status_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'model_id' => 'integer',
        'name' => 'string',
        'url' => 'string',
        'image' => 'string',
        'status_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function model()
    {
        return $this->belongsTo(\App\Models\Model::class);
    }

}
