<?php

namespace Tests;

use App\Exceptions\Handler;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException as BindingResolutionExceptionAlias;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Exception Handler 인스턴스.
     *
     * @var Handler
     */
    protected $oldExceptionHandler;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionExceptionAlias
     * @throws Exception
     */
    protected function setUp() : void
    {
        if (! $this->app) {
            $this->refreshApplication();
        }

        if ($this->app->environment() !== 'testing' || config('database.default') !== 'sqlite') {
            throw new Exception('Failed to read PHPUnit configuration file.');
        }

        parent::setUp();

        $this->disableExceptionHandling();
    }

    /**
     * 주어진 User 모델을 로그인 상태로 만듭니다.
     *
     * @param  User|null  $user
     * @return $this
     */
    protected function signIn(User $user = null)
    {
        $user = $user ?: create(User::class);

        $this->actingAs($user);

        return $this;
    }

    /**
     * Http 환경에서는 오류 페이지를 렌더링해서 리다이렉트 합니다.
     * Test 환경에서는 Laravel의 Exception Handling을 비활성화하고 예외를 던집니다.
     *
     * @throws BindingResolutionExceptionAlias
     * @see https://gist.github.com/adamwathan/125847c7e3f16b88fa33a9f8b42333da
     */
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new TestHandler);
    }

    /**
     * Laravel의 Exception Handling을 활성화합니다.
     *
     * @return $this
     * @see https://gist.github.com/adamwathan/125847c7e3f16b88fa33a9f8b42333da
     */
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }
}
