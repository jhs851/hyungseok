<?php

namespace App\SocialiteProviders\Naver;

use App\Core\SocialProvideSupporter;
use GuzzleHttp\Exception\GuzzleException;
use SocialiteProviders\Manager\OAuth2\User;
use SocialiteProviders\Naver\Provider as BaseNaverProvider;

class NaverProvider extends BaseNaverProvider
{
    use SocialProvideSupporter;

    /**
     * 소셜과의 연동을 해제합니다.
     *
     * @param string $code
     * @param string $token
     * @param array  $user
     * @throws GuzzleException
     */
    protected function removeAccessTokenResponse(string $code, string $token, array $user): void
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
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://openapi.naver.com/v1/nid/me',
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true)['response'];
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
