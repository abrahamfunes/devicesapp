<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MobileFaq
 * @package App\Models
 * @version September 11, 2017, 5:13 pm UTC
 */
class MobileFaq extends BaseModel
{
    #use SoftDeletes;

    public $table = 'mobile_faqs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    #protected $dates = ['deleted_at'];


    public $fillable = [
        'model_id',
        'question',
        'answer',
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
        'question' => 'string',
        'answer' => 'string',
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
