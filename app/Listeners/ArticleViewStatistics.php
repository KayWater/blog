<?php

namespace App\Listeners;

use App\Events\ArticleView;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticleViewStatistics
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArticleView  $event
     * @return void
     */
    public function handle(ArticleView $event)
    {
        //
        dd($event);
        
    }
}
