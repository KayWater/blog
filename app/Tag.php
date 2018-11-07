<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    //
    use SoftDeletes;
    /**
     * 需要转换成日期的属性
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * article relate
     * 
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }
}
