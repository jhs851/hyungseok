<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\{Event, Notification, URL};
use Tests\TestCase;

class VerificationTest extends TestCase
{   
    use DatabaseMigrations;

    /**
     * 손님은 접근할 수 없습니다.
     */
    public function testGuestsCannotAccess() : void
    {
        $this->withExceptionHandling();

        $this->get(route('verification.notice'))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('login'));

        $this->get(URL::signedRoute('verification.verify', ['id' => create(User::class)->id]))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('login'));

        $this->get(route('verification.resend'))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('login'));
    }

    /**
     * 사용자가 이메일 인증 폼을 요청했을 때 이메일이 인증된 사용자는 리디렉션 합니다.
     */
    public function testUserWhoseVerifiedWillBeRedirected() : void
    {
        // User factory에서 email_verified_at 컬럼을 채워 넣습니다.
        $this->signIn($verifiedUser = create(User::class));

        $this->get(route('verification.notice'))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));

        $this->get( URL::signedRoute('verification.verify', ['id' => $verifiedUser->id]))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));

        $this->get(route('verification.resend'))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * verfied 되지 않고, 로그인한 사용자는 이메일을 전송하는 view에 접근할 수 있습니다.
     */
    public function testHasNotVerifiedAndAuthenticatedUserCanAccessVerficiationNoticieView() : void
    {
        $this->signIn(factory(User::class)->state('unconfirmed')->create());

        $this->get(route('verification.notice'))
             ->assertStatus(200);
    }

    /**
     * 이메일 인증시 링크가 서명되있는지 확인합니다.
     */
    public function testVerifyThatTheLinkIsSignedWhenVerificateTheEmail()
    {
        $this->signIn();

        $this->expectException(InvalidSignatureException::class);

        $this->get(route('verification.verify', ['id' => auth()->id()]));
    }

    /**
     * 이메일 인증시 링크를 확인합니다.
     */
    public function testCheckTheLinkWhenVerificatingEmail() : void
    {
        $this->signIn();

        $otherUser = factory(User::class)->state('unconfirmed')->create();

        $this->expectException(AuthorizationException::class);

        $this->get(URL::signedRoute('verification.verify', ['id' => $otherUser->id]));
    }

    /**
     * 올바른 링크로 이메일 인증을 시도한다면 이메일을 인증합니다.
     */
    public function testIfAttemptToVerificateAnEmailWithTheCorrectLinkVerificateEmail()
    {
        $this->signIn($user = factory(User::class)->state('unconfirmed')->create());

        $this->assertFalse(auth()->user()->hasVerifiedEmail());

        $this->get(URL::signedRoute('verification.verify', ['id' => auth()->id()]));

        $this->assertTrue(auth()->user()->hasVerifiedEmail());
    }

    /**
     * 이메일이 인증되면 이벤트를 실행합니다.
     */
    public function testEmailVerifiedToFireEvent()
    {
        Event::fake();

        $this->signIn(factory(User::class)->state('unconfirmed')->create());

        $this->get(URL::signedRoute('verification.verify', ['id' => auth()->id()]));

        Event::assertDispatched(Verified::class);
    }

    /**
     * 이메일 인증되면 리디렉션 합니다.
     */
    public function testEmailVerificatedRedirect()
    {
        $this->signIn();

        $this->get(URL::signedRoute('verification.verify', ['id' => auth()->id()]))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * 이메일이 인증되지 않은 사용자는 인증 이메일을 전송할 수 있습니다.
     */
    public function testUsersWhoseEmailNotVerificatedCanSendVerificationEmails()
    {
        $this->signIn($user = factory(User::class)->state('unconfirmed')->create());

        Notification::fake();

        $this->get(route('verification.resend'));

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * 인증 이메일을 전송한 후에 resent 세션과 함께 리디렉션 합니다.
     */
    public function testAfterSendingTheVerificationEmailRedirectItWithResentSession()
    {
        $this->signIn(factory(User::class)->state('unconfirmed')->create());

        $this->get(route('verification.resend'))
             ->assertStatus(302)
             ->assertSessionHas('resent');
    }
}
