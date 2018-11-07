<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Article;

class StatisticsArticleView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * article model instance
     * @var App\Article $article
     */
    protected $article;
    /**
     * Create a new job instance.
     * @param App\Article $article
     * @return void
     */
    public function __construct(Article $article)
    {
        //
        $this->article = $article;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->article->increment('views', 1);
    }
}
