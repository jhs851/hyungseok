<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AdminLoginationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 로그인 페이지는 게스트만 접근할 수 있습니다.
     */
    public function testTheLoginPageIsAccessibleOnlyToTheGuests() : void
    {
        $this->signIn();

        $this->get(route('admin.login'))
             ->assertRedirect(route('home'));
    }

    /**
     * 관리자가 로그인 페이지로 접근하면 대쉬보드로 리디렉션 합니다.
     */
    public function testTheAdministratorWillRedirectToTheDashboardWhenAccessTheLoginPage() : void
    {
        $this->signIn(factory(User::class)->state('admin')->create());

        $this->get(route('admin.login'))
             ->assertRedirect(route('admin.dashboard'));
    }
    
    /**
     * Administrator 미들웨어는 관리자가 아니라면 401 예외를 반환합니다.
     */
    public function testVerifyThatTheAdministratorMiddlewareIsAnadministrator() : void
    {
        $this->signIn();

        $this->withExceptionHandling()
             ->get(route('admin.dashboard'))
             ->assertStatus(401);
    }
}
