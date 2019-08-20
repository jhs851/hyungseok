<?php

namespace App\SocialiteProviders\Kakao;

use SocialiteProviders\Manager\SocialiteWasCalled;

class KakaoExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('kakao', KakaoProvider::class);
    }
}
