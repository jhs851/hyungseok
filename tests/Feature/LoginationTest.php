<?php

namespace Tests\Feautre;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\{DatabaseMigrations, TestResponse};
use Illuminate\Support\Facades\Event;
use Str;
use Tests\TestCase;

class LoginationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 더미 User 인스턴스.
     *
     * @var User
     */
    protected $user;

    /**
     * RateLimiter 인스턴스.
     *
     * @var RateLimiter
     */
    protected $limiter;

    /**
     * 최대 인증 시도 가능 횟수.
     *
     * @var int
     */
    protected $maxAttempts;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->user = create(User::class);

        $this->limiter = app(RateLimiter::class);

        $this->maxAttempts = 5;
    }

    /**
     * 로그인 된 유저는 로그인 폼에 접근할 수 없습니다.
     */
    public function testAuthenticatedUsersCannotAccess() : void
    {
        $this->signIn();

        $this->get(route('login'))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));

        $this->publishLogin()
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * 필요한 필드가 로그인 폼에 보입니다.
     */
    public function testTheRequiredFieldsAreVisibleInTheLoginForm() : void
    {
        $this->get(route('login'))
             ->assertSee("name=\"{$this->username()}\"")
             ->assertSee('name="password"')
             ->assertSee('name="remember"');
    }

    /**
     * 컨트롤러에서 사용할 로그인 사용자 이름 필드는 반드시 필요합니다.
     */
    public function testUserNameFieldIsRequired() : void
    {
        $this->publishLogin([$this->username() => ''])
             ->assertSessionHasErrors($this->username());
    }

    /**
     * 비밀번호 필드는 반드시 필요합니다.
     */
    public function testPasswordFieldIsRequired() : void
    {
        $this->publishLogin(['password' => ''])
             ->assertSessionHasErrors('password');
    }

    /**
     * 로그인 정보가 올바르면 사용자가 인증됩니다.
     */
    public function testIfTheLoginInformationIsCorrectTheUserIsAuthenticated() : void
    {
        $this->assertFalse(auth()->check());

        $this->publishLogin();

        $this->assertTrue(auth()->check());
    }

    /**
     * 사용자가 인증에 실패하면 로그인 시도 횟수를 캐쉬에서 증가시킵니다.
     */
    public function testIfTheUserFailsToAuthenticationIncreaseTheLoginAttemptsInTheCache() : void
    {
        $this->assertEquals(0, $this->loginAttempts());

        $this->failedLogin();

        $this->assertEquals(1, $this->loginAttempts());

        $this->failedLogin();

        $this->assertEquals(2, $this->loginAttempts());
    }

    /**
     * 사용자 인증에 실패하면 세션에 에러 메시지를 저장합니다.
     */
    public function testIfUserAuthenticationFailsSaveTheMessageInTheSession() : void
    {
        $this->failedLogin()
             ->assertSessionHasErrors($this->username());
    }

    /**
     * 사용자가 최대 인증 시도 가능 횟수를 초과한다면 Lockout 이벤트를 실행하고, 사용자 로그인을 일시적으로 막습니다.
     */
    public function testIfTheUserFailsToAuthenticateMoreThanTheMaxAttempts() : void
    {
        Event::fake();

        for ($i = 0; $i < $this->maxAttempts; $i++) {
            $this->failedLogin();
        }

        $this->publishLogin()
             ->assertSessionHasErrors($this->username());

        Event::assertDispatched(Lockout::class);
    }

    /**
     * 사용자가 인증된 후에 CSRF 토큰을 재생성합니다.
     */
    public function testRegenerateTheCSRFTokenAfterTheUserHasAuthenticated() : void
    {
        $oldToken = csrf_token();

        $this->publishLogin();

        $this->assertNotEquals($oldToken, csrf_token());
    }

    /**
     * 사용자가 인증된 후에 캐쉬에 저장된 로그인 시도 횟수를 초기화 합니다.
     */
    public function testInitializesTheLoginAttemptAfterTheUserAuthenticated() : void
    {
        for ($i = 0; $i < $this->maxAttempts - 1; $i++) {
            $this->failedLogin();
        }

        $this->assertEquals(4, $this->loginAttempts());

        $this->publishLogin();

        $this->assertEquals(0, $this->loginAttempts());
    }

    /**
     * 사용자가 인증된 후에 flash 메시지와 함께 리디렉션 합니다.
     */
    public function testRedirectAfterAuthenticated() : void
    {
        $this->publishLogin()
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * 사용자가 로그아웃을 할 수 있습니다.
     */
    public function testAllowsTheUserToLogOut() : void
    {
        $this->signIn();

        $this->assertTrue(auth()->check());

        $this->post(route('logout'));

        $this->assertFalse(auth()->check());
    }

    /**
     * 사용자가 로그아웃을 한 후에 flash 메시지와 함께 리디렉션 합니다.
     */
    public function testTheUserLogoutAndRedirectsWithTheFlashMessage() : void
    {
        $this->post(route('logout'))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * 사용자 throttle 키에 대한 인증 시도 횟수를 반환합니다.
     *
     * @return int
     */
    protected function loginAttempts() : int
    {
        return $this->limiter->attempts($this->throttleKey());
    }

    /**
     * 사용자에 대한 throttle 키를 반환합니다.
     *
     * @return string
     */
    protected function throttleKey() : string
    {
        return Str::lower($this->user->{$this->username()}) . '|' . request()->ip();
    }

    /**
     * 로그인 POST 요청에 대한 응답을 반환합니다.
     *
     * @param  array  $overrides
     * @return TestResponse
     */
    protected function publishLogin(array $overrides = []) : TestResponse
    {
        return $this->withExceptionHandling()
                    ->post(route('login'), array_merge(
                        [$this->username() => $this->user->{$this->username()}, 'password' => 'password'],
                        $overrides
                    ));
    }

    /**
     * 사용자 인증을 실패합니다.
     *
     * @return TestResponse
     */
    protected function failedLogin() : TestResponse
    {
        return $this->publishLogin(['password' => 'failspassword']);
    }

    /**
     * 컨트롤러에서 사용할 로그인 사용자 이름을 가져옵니다.
     *
     * @return string
     */
    protected function username() : string
    {
        return 'email';
    }
}
