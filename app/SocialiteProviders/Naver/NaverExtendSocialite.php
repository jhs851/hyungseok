<?php

namespace App\SocialiteProviders\Naver;

use SocialiteProviders\Manager\SocialiteWasCalled;

class NaverExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('naver', NaverProvider::class);
    }
}
