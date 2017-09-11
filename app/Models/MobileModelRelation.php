<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class MobileModelRelation
 * @package App\Models
 * @version September 11, 2017, 7:21 pm UTC
 */
class MobileModelRelation extends BaseModel
{
    #use SoftDeletes;

    public $table = 'mobile_models_relations';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    #protected $dates = ['deleted_at'];


    public $fillable = [
        'model_id',
        'model_name',
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
        'model_name' => 'string',
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
