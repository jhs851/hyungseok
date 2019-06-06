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
            \SocialiteProviders\Naver\NaverExtendSocialite::class,
            \SocialiteProviders\Kakao\KakaoExtendSocialite::class,
            \SocialiteProviders\Google\GoogleExtendSocialite::class,
            \SocialiteProviders\Facebook\FacebookExtendSocialite::class,
        ]
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
