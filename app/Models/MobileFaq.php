<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MobileFaq
 * @package App\Models
 * @version September 11, 2017, 5:13 pm UTC
 */
class MobileFaq extends Model
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

    public static function boot()
    {
        static::created(function ($model) {
            \DB::connection('mysql_app')->insert('insert into mobile_faqs (id, model_id, question, answer) values (?, ?, ?, ?)', [$model->id, $model->model_id, $model->question, $model->answer]);
        });

        static::updated(function ($model) {
            \DB::connection('mysql_app')->update('update mobile_faqs SET model_id = ?, question = ?, answer = ?, status_id = ? WHERE id = ?', [$model->model_id, $model->question, $model->answer, $model->status_id, $model->id]);
        });

        parent::boot();
    }
}
