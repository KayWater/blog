<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    //
    use SoftDeletes;
    /**
     * 需要转换成日期的属性
     */
    protected $dates = ['deleted_at', 'published_at'];
    
    /**
     * tag relate
     * 
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
