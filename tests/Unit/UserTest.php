<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * User 인스턴스.
     *
     * @var User
     */
    protected $user;

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
    }

    /**
     * 유저 모델의 fillable은 이름, 이메일, 비밀번호, 아바타 경로 입니다.
     */
    public function testItFillableIsTheNameAndEmailAndPasswordAndAvatarPath() : void
    {
        $this->assertEquals(['name', 'email', 'password', 'avatar_path'], $this->user->getFillable());
    }

    /**
     * 유저 모델의 hidden은 비밀번호와 기억 토큰 입니다.
     */
    public function testItHiddenIsThePasswordAndRememberToken() : void
    {
        $this->assertEquals(['password', 'remember_token'], $this->user->getHidden());
    }

    /**
     * 유저 모델의 dates는 created_at, updated_at, email_verfied_at 입니다.
     */
    public function testItDatesTheEmailVerifiedAt() : void
    {
        $this->assertEquals(
            ['email_verfied_at', User::CREATED_AT, User::UPDATED_AT],
            $this->user->getDates()
        );
    }

    /**
     * 유저 모델은 여러개의 개발 포스트를 가지고 있습니다.
     */
    public function testItHasManyDevelopments() : void
    {
        $this->assertInstanceOf(Collection::class, $this->user->developments);
    }

    /**
     * 유저 모델은 여러개의 활동을 가지고 있습니다.
     */
    public function testItHasManyActivities() : void
    {
        $this->assertInstanceOf(Collection::class, $this->user->activities);
    }

    /**
     * 유저 모델은 회원가입을 할 수 있습니다.
     */
    public function testItCanRegister() : void
    {
        $user = make(User::class);

        $this->user->register($user->toArray());

        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    /**
     * 유저 모델은 관리자인지 확인할 수 있습니다.
     */
    public function testItCanDetermineIsAdmin() : void
    {
        $admin = factory(User::class)->state('admin')->create();

        $this->assertTrue($admin->isAdmin());
    }

    /**
     * 유저 모델은 관리자인지 확인하는 Mutator를 가지고 있습니다.
     */
    public function testItHasIsAdminMutator() : void
    {
        $admin = factory(User::class)->state('admin')->create();

        $this->assertTrue($admin->isAdmin);
    }
    
    /**
     * 유저 모델은 이메일이 인증되었는지 확인하는 Mutator를 가지고 있습니다.
     */
    public function testItHasDetermineVerifiedEmailMutator() : void
    {
        $this->assertTrue($this->user->hasVerifiedEmail);
    }

    /**
     * 유저 모델은 아바타 경로를 반환하는 Mutator를 가지고 있습니다.
     */
    public function testItHasAvatarMutatorAndCanDetermineTheirAvatarPath() : void
    {
        $this->assertNotNull($this->user->avatar);

        $this->assertEquals(asset('avatars/default.png'), $this->user->avatar);

        $this->user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals(asset('avatars/me.jpg'), $this->user->avatar);
    }
}
