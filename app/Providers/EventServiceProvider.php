<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Laravel\Passport\Events\AccessTokenCreated' => [
            'App\Listeners\Auth\RevokeOldTokens',
        ],
        'Laravel\Passport\Events\RefreshTokenCreated' => [
            'App\Listeners\Auth\PruneOldTokens',
        ],
        // 'App\Events\ArticleView' => [
        //     'App\Listeners\ArticleViewStatistics',
        // ],
        // 'SocialiteProviders\Manager\SocialiteWasCalled' => [
        //     'SocialiteProviders\Weibo\WeiboExtendSocialite@handle',
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
