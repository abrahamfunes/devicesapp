<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class FilesCategory
 */
class FilesCategory extends BaseModel
{
    protected $table = 'files_categories';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $guarded = [];

        
}