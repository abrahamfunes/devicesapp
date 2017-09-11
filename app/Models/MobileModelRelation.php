<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MobileModelRelation
 * @package App\Models
 * @version September 11, 2017, 7:21 pm UTC
 */
class MobileModelRelation extends Model
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

    public static function boot()
    {
        static::created(function ($model) {
            \DB::connection('mysql_app')->insert('insert into mobile_models_relations (id, model_id, model_name) values (?, ?, ?)', [$model->id, $model->model_id, $model->model_name]);
        });

        static::updated(function ($model) {
            \DB::connection('mysql_app')->update('update mobile_models_relations SET model_id = ?, model_name = ?, status_id = ? WHERE id = ?', [$model->model_id, $model->model_name, $model->status_id, $model->id]);
        });

        parent::boot();
    }
}
