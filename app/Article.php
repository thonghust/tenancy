<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    public $table = 'articles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'name',
        'image',
        'summary',
        'content',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'image' => 'string',
        'summary' => 'string',
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'image' => 'required',
        'summary' => 'required',
        'content' => 'required',
    ];
}
