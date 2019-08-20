<?php

namespace App\SocialiteProviders\Kakao;

use App\Core\SocialProvideSupporter;
use GuzzleHttp\Exception\GuzzleException;
use SocialiteProviders\Kakao\KakaoProvider as BaseKakaoProvider;

class KakaoProvider extends BaseKakaoProvider
{
    use SocialProvideSupporter;

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
     * @throws GuzzleException
     */
    protected function removeAccessTokenResponse(string $code, string $token): void
    {
        $this->getHttpClient()->request('POST', $this->getUnlinkUrl(), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
        ]);
    }
}
