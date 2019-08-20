<?php

namespace App\SocialiteProviders\Naver;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Two\{AbstractProvider, InvalidStateException};
use SocialiteProviders\Manager\OAuth2\User;
use SocialiteProviders\Naver\NaverProvider as BaseNaverProvider;

class NaverProvider extends BaseNaverProvider
{
    /**
     * @return User
     * @throws GuzzleException
     * @throws ValidationException
     */
    public function user(): User
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
     * @param string $token
     * @param array  $user
     * @return AbstractProvider
     * @throws GuzzleException
     * @throws ValidationException
     */
    protected function validate(string $token, array $user): AbstractProvider
    {
        $validator = Validator::make($user, $this->config['rules']);

        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            $this->removeAccessTokenResponse($this->getCode(), $token);

            throw $exception->redirectTo('/social/invalid');
        }

        return $this;
    }

    /**
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

    /**
     * @return array
     */
    public static function additionalConfigKeys(): array
    {
        return ['rules'];
    }
}
