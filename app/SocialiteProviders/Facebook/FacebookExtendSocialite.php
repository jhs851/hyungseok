<?php

namespace App\SocialiteProviders\Facebook;

use SocialiteProviders\Manager\SocialiteWasCalled;

class FacebookExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'facebook', FacebookProvider::class
        );
    }
}
