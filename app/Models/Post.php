<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;

    // Constant of post status 
    const POST_STATUS_PUBLISHED = 1;

    /**
     * 需要转换成日期的属性
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'published_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'draft_id',
    ];
    
    /**
     * Get tags of this post
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }

    /**
     * Get user this post belongs to
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
