<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Model
 */
class Model extends BaseModel {

    protected $table = 'models';

    public $timestamps = false;

    protected $fillable = [
        'type_id',
        'name',
        'version',
        'description',
    ];

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(ModelsType::class, 'type_id');
    }

    public function modelsType()
    {
        return $this->belongsTo(ModelsType::class, 'type_id');
    }

//    public function modelItems()
//    {
//        return $this->hasMany(ModelItem::class, 'model_id');
//    }

    public function modelFiles()
    {
        return $this->hasMany(File::class, 'reference_id')->where(['reference_type' => 'model', 'status_id' => 1]);
    }

    public function products()
    {
        return $this->hasMany(Product::class)->whereStatusId(true);
    }

    public function mobileApp()
    {
        return $this->hasOne(MobileModelRelation::class, 'model_id')->whereStatusId(1);
    }

    public function faqs()
    {
        return $this->hasMany(MobileFaq::class)->whereStatusId(1);
    }

    public function sliders()
    {
        return $this->hasMany(MobileSlider::class)->whereStatusId(1);
    }

}