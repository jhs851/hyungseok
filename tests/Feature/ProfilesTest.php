<?php

namespace Tests\Feature;

use App\Models\{Development, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 사용자는 회원정보를 가지고 있습니다.
     */
    public function testAUserHasAProfile() : void
    {
        $user = create(User::class);

        $this->get(route('users.show', $user->id))
             ->assertSee($user->name);
    }

    /**
     * 회원정보에는 사용자가 작성한 모든 개발 포스트를 볼 수 있습니다.
     */
    public function testProfilesDisplayAllDevelopmentsCreatedByTheAssociatedUser()
    {
        $user = create(User::class);
        $development = create(Development::class, ['user_id' => $user->id]);
        $this->get(route('users.show', $user->id))
             ->assertSee($development->title)
             ->assertSee($development->bodyy);
    }
}
