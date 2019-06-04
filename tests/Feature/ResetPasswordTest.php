<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\{DatabaseMigrations, TestResponse};
use Illuminate\Support\Facades\{Event, Hash};
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 손님은 접근할 수 없습니다.
     */
    public function testGuestsCannotAccess() : void
    {
        $this->signIn();

        $this->get(route('password.reset', ['token' => $this->getToken(auth()->user())]))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));

        $this->publishPasswordUpdate()
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * Password Reset 폼에 필요한 필드들이 보입니다.
     */
    public function testViewTheFieldsRequiredForRResetForm() : void
    {
        $user = make(User::class);

        $this->get(route('password.reset', ['token' => $this->getToken($user)]))
             ->assertSee('name="token"')
             ->assertSee('name="email"')
             ->assertSee('name="password"')
             ->assertSee('name="password_confirmation"');
    }

    /**
     * 토큰, 이메일, 비밀번호, 비밀번호 확인 필드는 반드시 필요합니다.
     */
    public function testCheckTheFieldsThatAreRequired() : void
    {
        $this->publishPasswordUpdate(['token' => ''])
             ->assertSessionHasErrors('token');

        $this->publishPasswordUpdate(['email' => ''])
             ->assertSessionHasErrors('email');

        $this->publishPasswordUpdate(['password' => ''])
             ->assertSessionHasErrors('password');

        $this->publishPasswordUpdate(['password_confirmation' => ''])
             ->assertSessionHasErrors('password');
    }

    /**
     * 사용자는 비밀번호를 변경할 수 있습니다.
     */
    public function testCanChangePassword() : void
    {
        $this->publishPasswordUpdate([
            'password' => 'passwordupdated',
            'password_confirmation' => 'passwordupdated',
        ]);

        $this->assertDatabaseMissing('users', [
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * 비밀번호 변경 후에 이벤트를 실행합니다.
     */
    public function testAfterChangingPasswordFireTheEvent() : void
    {
        Event::fake();

        $this->publishPasswordUpdate();

        Event::assertDispatched(PasswordReset::class);
    }

    /**
     * 비밀번호 변경 후에 해당 회원을 로그인합니다.
     */
    public function testAftterChangingPasswordAuthenticatedthatUser() : void
    {
        $user = create(User::class);

        $this->publishPasswordUpdate([
            'token' => $this->getToken($user),
            'email' => $user->email,
        ]);

        $this->assertEquals(auth()->user()->id, $user->id);
    }

    /**
     * 비밀번호 변경 후에 플래쉬 메시지와 함께 리디렉션 합니다.
     */
    public function testAfterChangingPasswordRedirectWithFlashMessage()
    {
        $this->publishPasswordUpdate()
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * 비밀번호 변경 POST 요청을 반환합니다.
     *
     * @param  array  $overrides
     * @return TestResponse
     */
    protected function publishPasswordUpdate(array $overrides = []) : TestResponse
    {
        $user = create(User::class);
        $data = [
            'token' => $this->getToken($user),
            'email' => $user->email,
            'password' => $this->password(),
            'password_confirmation' => $this->password(),
        ];

        return $this->withExceptionHandling()
            ->post(
                route('password.update'),
                array_merge($data, $overrides)
            );
    }

    /**
     * 테스트에 기본적으로 쓰일 비밀번호 값을 반환합니다.
     * 
     * @return string
     */
    protected function password() : string 
    {
        return 'password';
    }

    /**
     * 주어진 User에 해당하는 token을 생성하고 반환합니다.
     *
     * @param  User  $user
     * @return string
     */
    protected function getToken(User $user) : string
    {
        return app('auth.password')->createToken($user);
    }
}
