<?php

namespace App\SocialiteProviders\Kakao;

use App\Core\SocialProvideSupporter;
use GuzzleHttp\Exception\GuzzleException;
use SocialiteProviders\Kakao\KakaoProvider as BaseKakaoProvider;

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
}
