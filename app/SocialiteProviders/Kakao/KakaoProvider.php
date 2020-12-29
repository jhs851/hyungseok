<?php

namespace App\SocialiteProviders\Kakao;

use App\Core\SocialProvideSupporter;
use GuzzleHttp\Exception\GuzzleException;
use SocialiteProviders\Kakao\KakaoProvider as BaseKakaoProvider;
use SocialiteProviders\Manager\OAuth2\User;

class KakaoProvider extends BaseKakaoProvider
{
    use SocialProvideSupporter;

    /**
     * Get the POST fields for the token request.
     *
     * @param string $code
     *
     * @return array
     */
    protected function getTokenFields($code): array
    {
        return [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUrl,
            'code' => $code,
        ];
    }

    /**
     * Get the Unlink URL for the provider.
     *
     * @return string
     */
    protected function getUnlinkUrl(): string
    {
        return 'https://kapi.kakao.com/v1/user/unlink';
    }

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
        $this->getHttpClient()->request('POST', $this->getUnlinkUrl(), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
        ]);
    }

    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param array $user
     *
     * @return \Laravel\Socialite\User
     */
    protected function mapUserToObject(array $user)
    {
        $is_email_valid = array_get($user, 'kakao_account.is_email_valid');
        $is_email_verified = array_get($user, 'kakao_account.is_email_verified');

        $user = [
            'id' => $user['id'],
            'nickname' => $user['properties']['nickname'],
            'name' => $user['properties']['nickname'],
            'email' => $is_email_valid && $is_email_verified ? array_get($user, 'kakao_account.email') : null,
            'avatar' => array_get($user, 'properties.profile_image'),
        ];

        return (new User())->setRaw($user)->map($user);
    }
}
