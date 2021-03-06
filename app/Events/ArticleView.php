<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Article;

class ArticleView
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * article model instance
     * @var $article
     */
    public $article;
    
    /**
     * Create a new event instance.
     * @param \App\Article $article
     * @return void
     */
    public function __construct(Article $article)
    {
        //
        $this->article = $article;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
