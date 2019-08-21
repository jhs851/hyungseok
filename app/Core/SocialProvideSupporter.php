<?php

namespace App\Core;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Two\{AbstractProvider, InvalidStateException};
use SocialiteProviders\Manager\OAuth2\User;
use Laravel\Socialite\Two\User as BaseUser;

trait SocialProvideSupporter
{
    /**
     * 사용자를 반환합니다.
     *
     * @return BaseUser
     */
    public function user(): BaseUser
    {
        if ($this->hasInvalidState()) {
            throw new InvalidStateException();
        }

        $response = $this->getAccessTokenResponse($this->getCode());
        $userByToken = $this->getUserByToken($token = $this->parseAccessToken($response));
        $user = $this->validate($token, $userByToken)->mapUserToObject($userByToken);

        $this->credentialsResponseBody = $response;

        if ($user instanceof User) {
            $user->setAccessTokenResponseBody($this->credentialsResponseBody);
        }

        return $user->setToken($token)
            ->setRefreshToken($this->parseRefreshToken($response))
            ->setExpiresIn($this->parseExpiresIn($response));
    }

    /**
     * 소셜로부터 받은 정보를 검사합니다.
     *
     * @param string $token
     * @param array  $user
     * @return AbstractProvider
     */
    protected function validate(string $token, array $user): AbstractProvider
    {
        $validator = Validator::make($user, $this->config['rules']);

        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            $this->removeAccessTokenResponse($this->getCode(), $token, $user);

            throw $exception->redirectTo('/social/invalid');
        }

        return $this;
    }

    /**
     * 소셜과의 연동을 해제합니다.
     *
     * @param string $code
     * @param string $token
     * @param array  $user
     */
    protected function removeAccessTokenResponse(string $code, string $token, array $user): void
    {
        //
    }

    /**
     * 가져올 설정을 추가합니다.
     *
     * @return array
     */
    public static function additionalConfigKeys(): array
    {
        return ['rules'];
    }
}
