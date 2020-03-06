<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    //
    use SoftDeletes;

    const STATUS_AVAILABLE = 1;

    /**
     * The attributes should be convert to date 
     * @var array
     */
    protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];
    
    /**
     * Get post that has this tag
     */
    public function posts() 
    {
        return $this->morphedByMany('App\Models\Post', 'taggable');
    }
}
