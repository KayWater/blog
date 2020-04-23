<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    //
    
    /**
     * 需要转换成日期的属性
     * @var array
     */
    protected $dates = ['created_at', 'updated_at' ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['post_id'];
   
    /**
     * 应该被转换成原生类型的属性
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Get user this post belongs to
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get tags of this post
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }
}
