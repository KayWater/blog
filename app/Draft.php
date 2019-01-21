<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Draft extends Model
{
    //
    use SoftDeletes;
    
    /**
     * 需要转换成日期的属性
     * @var array
     */
    protected $dates = ['deleted_at' ];
   
    /**
     * 应该被转换成原生类型的属性
     * @var array
     */
    protected $casts = [
    ];
}
