<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Article extends Model
{
    //
    use SoftDeletes;
    use Searchable;
    /**
     * 需要转换成日期的属性
     */
    protected $dates = ['deleted_at', 'published_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'draft_id',
    ];
    
    /**
     * 获取模型的可搜索数据
     * 
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only('title', 'content');
    }
    
    /**
     * tag relate
     * 
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
