<?php

namespace App\SocialiteProviders\Github;

use SocialiteProviders\Manager\SocialiteWasCalled;

class GithubExtendSocialite
{
    /**
     * Execute the provider.
     *
     * @param SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('github', GithubProvider::class);
    }
}
