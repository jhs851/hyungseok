<?php

namespace Tests\Feautre;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\{DatabaseMigrations, TestResponse};
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 로그인한 사용자는 회원가입 폼에 접근할 수 없습니다.
     */
    public function testAuthenticatedUsersCannotAccess() : void
    {
        $this->signIn();

        $this->get(route('register'))
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));

        $this->publishRegister()
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * 회원가입 폼에 avatar_path 를 제외한 User fillable input들이 보입니다.
     */
    public function testWllSeeTheRequiredFillableFieldsWithoutAvatarPath() : void
    {
        $response = $this->get(route('register'));

        $fields = array_filter(
            array_merge(make(User::class)->getFillable(), ['password_confirmation']),
            function ($field) {
                return $field !== 'avatar_path';
            }
        );

        foreach ($fields as $field) {
            $response->assertSee("name=\"{$field}\"");
        }
    }

    /**
     * 이름 필드는 반드시 필요햡니다.
     */
    public function testNameFieldIsRequired() : void
    {
        $this->publishRegister(['name' => ''])
             ->assertSessionHasErrors('name');
    }

    /**
     * 이메일 필드는 반드시 필요합니다.
     */
    public function testEmailFieldIsRequired() : void
    {
        $this->publishRegister(['email' => ''])
             ->assertSessionHasErrors('email');
    }

    /**
     * 비밀번호 필드는 반드시 필요합니다.
     */
    public function testPasswordFieldIsRequired() : void
    {
        $this->publishRegister(['password' => ''])
             ->assertSessionHasErrors('password');
    }

    /**
     * 비밀번호 확인 필드는 반드시 필요합니다.
     */
    public function testPasswordConfirmationFieldRequired() : void
    {
        $this->publishRegister(['password_confirmation' => ''])
             ->assertSessionHasErrors('password');
    }

    /**
     * 유효성 검사에 통과되면 사용자를 데이터 베이스에 삽입합니다.
     */
    public function testInsertInTheDatabaseUser()
    {
        $user = make(User::class);

        $this->publishRegister($user->toArray());

        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    /**
     * 사용자를 생성하고 이벤트를 실행합니다.
     */
    public function testFireEventAfterCreateUser()
    {
        Event::fake();

        $this->publishRegister();

        Event::assertDispatched(Registered::class);
    }

    /**
     * 사용자를 생성한 뒤에 로그인 합니다.
     */
    public function testLoginAfterCreateUser()
    {
        $user = make(User::class);

        $this->publishRegister($user->toArray());

        $this->assertEquals(auth()->user()->email, $user->email);
    }

    /**
     * 사용자를 생성한 뒤에 리디렉션 합니다.
     */
    public function testRedirectAfterCreateUser()
    {
        $this->publishRegister()
             ->assertStatus(302)
             ->assertSessionHas('flash_notification')
             ->assertRedirect(route('home'));
    }

    /**
     * 회원가입 POST 요청에 대한 응답을 반환합니다.
     *
     * @param  array  $overrides
     * @return TestResponse
     */
    protected function publishRegister(array $overrides = []) : TestResponse
    {
        $user = make(User::class, $overrides);

        return $this->withExceptionHandling()
            ->post(
                route('register'), array_merge(
                    $user->getAttributes(),
                    ['password_confirmation' => $overrides['password_confirmation'] ?? $user->password]
                )
            );
    }
}
