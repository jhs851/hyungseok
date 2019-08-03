<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException as BindingResolutionExceptionAlias;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersTestFromAdminTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionExceptionAlias
     * @throws Exception
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->signIn(factory(User::class)->state('admin')->create());
    }

    /**
     * 관리자는 사용자를 생성할 때 이름 값은 필수 입니다.
     */
    public function testNameFieldIsRequired() : void
    {
        $this->publishCreate(['name' => ''])
             ->assertSessionHasErrors(['name']);
    }

    /**
     * 관리자는 사용자를 생성할 때 이메일 값은 필수 입니다.
     */
    public function testEmailFieldIsRequired() : void
    {
        $this->publishCreate(['email' => ''])
            ->assertSessionHasErrors(['email']);
    }

    /**
     * 관리자는 사용자를 생성할 때 비밀번호 값은 필수 입니다.
     */
    public function testPasswordFieldIsRequired() : void
    {
        $this->publishCreate(['password' => ''])
            ->assertSessionHasErrors(['password']);
    }

    /**
     * 관리자는 사용자를 생성할 때 비밀번호 확인 값은 필수 입니다.
     */
    public function testPasswordConfirmationFieldIsRequired() : void
    {
        $this->publishCreate(['password_confirmation' => ''])
            ->assertSessionHasErrors(['password']);
    }

    /**
     * 관리자는 사용자를 생성할 수 있습니다.
     */
    public function testAdminCanCreateUsers() : void
    {
        $this->publishCreate(['name' => 'JohnDoe']);

        $this->assertDatabaseHas('users', ['name' => 'JohnDoe']);
    }

    /**
     * 관리자는 사용자를 변경할 때 이름 값은 필수 입니다.
     */
    public function testWhenUpdateUserNameFieldIsRequired() : void
    {
        $this->publishUpdate(['name' => ''])
             ->assertSessionHasErrors('name');
    }

    /**
     * 관리자는 사용자를 변경할 때 비밀번호 값이 있을 때만 변경합니다.
     */
    public function testWhenUpdateUserOnlyUpdateItIfThereIsAPasswordValue() : void
    {
        $user = create(User::class, ['password' => 'password']);
        $password = $user->password;

        // 비밀번호 값이 없다면 비밀번호 유지
        $this->publishUpdate(['password' => ''], $user);

        $this->assertEquals($password, $user->fresh()->password);

        // 비밀번호 값이 있다면 비밀번호 변경
        $this->publishUpdate([
            'password' => 'Updated password',
            'password_confirmation' => 'Updated password',
        ], $user);

        $this->assertNotEquals($password, $user->fresh()->password);
    }

    /**
     * 관리자는 사용자를 변경할 수 있습니다.
     */
    public function testAdminCanUpdateUsers() : void
    {
        $this->publishUpdate([
            'name' => 'Can Update',
            'password' => '',
        ]);

        $this->assertDatabaseHas('users', ['name' => 'Can Update']);
    }

    /**
     * 관리자는 사용자를 삭제할 수 있습니다.
     */
    public function testAdminCanDeleteUsers() : void
    {
        $user = create(User::class);

        $this->delete(route('admin.users.destroy', $user->id));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * 사용자 생성 POST 요청에 대한 응답을 반환합니다.
     *
     * @param  array  $overrides
     * @return TestResponse
     */
    protected function publishCreate(array $overrides = []) : TestResponse
    {
        $user = make(User::class, $overrides);

        return $this->withExceptionHandling()
            ->post(
                route('admin.users.store'), array_merge(
                    $user->getAttributes(),
                    ['password_confirmation' => $overrides['password_confirmation'] ?? $user->password]
                )
            );
    }

    /**
     * 사용자 변경 PUT 요청에 대한 응답을 반환합니다.
     *
     * @param  array  $data
     * @param  User|null  $user
     * @return TestResponse
     */
    protected function publishUpdate(array $data = [], User $user = null) : TestResponse
    {
        $user = $user ?: create(User::class);

        return $this->withExceptionHandling()
            ->put(route('admin.users.update', $user->id), array_merge(
                $user->getAttributes(),
                $data
            ));
    }
}
