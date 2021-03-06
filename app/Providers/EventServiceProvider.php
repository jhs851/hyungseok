<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            \App\SocialiteProviders\Naver\NaverExtendSocialite::class,
            \App\SocialiteProviders\Kakao\KakaoExtendSocialite::class,
            \App\SocialiteProviders\Facebook\FacebookExtendSocialite::class,
        ],
        \App\Events\DevelopmentRecivedNewComment::class => [
            \App\Listeners\NotifyMentionedUsers::class,
            \App\Listeners\NotifyAWriter::class,
        ],
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
