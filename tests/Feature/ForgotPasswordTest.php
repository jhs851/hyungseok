<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\{DatabaseMigrations, TestResponse};
use Illuminate\Support\Facades\{Notification, Password};
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 손님은 접근할 수 없습니다.
     */
    public function testGuestsCannotAccess() : void
    {
        $this->signIn();

        $this->get(route('password.request'))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));

        $this->publishSentEmail(auth()->user()->email)
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * 비밀번호 초기화 폼에 PasswordRequest Component를 볼 수 있습니다.
     */
    public function testCanCheckTheEmailInput() : void
    {
        $this->get(route('password.request'))
             ->assertSee('password-request');
    }

    /**
     * 이메일 필드는 필수입니다.
     */
    public function testEmailFieldIsRequired() : void
    {
        $this->withExceptionHandling()
             ->publishSentEmail()
             ->assertSessionHasErrors('email');
    }

    /**
     * 이메일로 회원을 찾을 수 없다면 실패한 응답을 반환합니다.
     */
    public function testIfTheMemberCannotBeFoundByEmailReturnFailedResponse() : void
    {
        $user = make(User::class);

        $response = $this->publishSentEmail($user->email);

        $response->assertStatus(404);

        $this->assertEquals($response->json('email'), trans(Password::INVALID_USER));
    }

    /**
     * 회원이 있다면 비밀번호 재설정 링크를 담은 메일을 발송합니다.
     */
    public function testIfHaveUserSendAnEmailWithToken() : void
    {
        Notification::fake();

        $user = create(User::class);

        $this->publishSentEmail($user->email);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * 메일을 정상적으로 발송했다면 성공 응답을 반환합니다.
     */
    public function testReturnsTheSuccessResponseIfSentTheMailNormally() : void
    {
        $user = create(User::class);

        $response = $this->publishSentEmail($user->email);

        $response->assertStatus(200);

        $this->assertEquals($response->json('status'), trans(Password::RESET_LINK_SENT));
    }

    /**
     * 주어진 이메일로 비밀번호 초기화 이메일을 전송합니다.
     *
     * @param  string  $email
     * @return TestResponse
     */
    protected function publishSentEmail(string $email = '') : TestResponse
    {
        return $this->post(route('password.email'), ['email' => $email]);
    }
}
