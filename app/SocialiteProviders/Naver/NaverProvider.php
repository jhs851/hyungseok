<?php

namespace App\SocialiteProviders\Naver;

use App\Core\SocialProvideSupporter;
use GuzzleHttp\Exception\GuzzleException;
use SocialiteProviders\Manager\OAuth2\User;
use SocialiteProviders\Naver\NaverProvider as BaseNaverProvider;

class NaverProvider extends BaseNaverProvider
{
    use SocialProvideSupporter;

    /**
     * 소셜과의 연동을 해제합니다.
     *
     * @param string $code
     * @param string $token
     * @throws GuzzleException
     */
    protected function removeAccessTokenResponse(string $code, string $token): void
    {
        $this->getHttpClient()->request('POST', $this->getTokenUrl(), [
            'headers' => ['Accept' => 'application/json'],
            'form_params' => array_merge(parent::getTokenFields($code), [
                'grant_type' => 'delete',
                'access_token' => $token,
                'service_provider' => static::IDENTIFIER,
            ]),
        ]);
    }

    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }
}
