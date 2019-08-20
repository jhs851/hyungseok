<?php

namespace App\SocialiteProviders\Github;

use App\Core\SocialProvideSupporter;
use Laravel\Socialite\Two\GithubProvider as BaseGithubProvider;

class GithubProvider extends BaseGithubProvider
{
    use SocialProvideSupporter;


}
