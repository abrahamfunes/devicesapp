<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class OperatingSystem
 */
class OperatingSystem extends BaseModel
{
    protected $table = 'operating_systems';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

        
}