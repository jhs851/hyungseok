<?php

namespace Tests\Feature;

use App\Models\{Development, User};
use Illuminate\Foundation\Testing\{DatabaseMigrations, TestResponse};
use Tests\TestCase;

class CreateDevelopmentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 게스트는 개발 포스트를 만들 수 없습니다.
     */
    public function testGuestsMayNotCreateDevelopments() : void
    {
        $this->withExceptionHandling();

        $this->get(route('developments.create'))
             ->assertRedirect(route('login'));

        $this->post(route('developments.store'))
             ->assertRedirect(route('login'));
    }

    /**
     * 이메일 인증을 하지 않은 유저는 개발 포스트를 만들 수 없습니다.
     */
    public function testNewUsersMustFirstConfirmTheirEmailBeforeCreatingDevelopments() : void
    {
        $this->signIn(create(User::class, ['email_verified_at' => null]));

        $this->post(route('developments.store'), make(Development::class)->toArray())
             ->assertRedirect(route('verification.notice'))
             ->assertSessionHas('flash_notification');
    }

    /**
     * 사용자는 새로운 개발 포스트를 만들 수 있습니다.
     */
    public function testAUserCanCreateNewDevelopments() : void
    {
        $this->signIn();

        $thread = make(Development::class);
        $response = $this->post(route('developments.store'), $thread->toArray());

        $this->get($response->headers->get('Location'))
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }

    /**
     * 제목 값은 반드시 있어야 합니다.
     */
    public function testADevelopmentRequiresATitle() : void
    {
        $this->publishDevelopment(['title' => ''])
             ->assertSessionHasErrors('title');
    }

    /**
     * 본문 값은 반드시 있어야 합니다.
     */
    public function testADevelopmentRequiresABody() : void
    {
        $this->publishDevelopment(['body' => ''])
            ->assertSessionHasErrors('body');
    }

    /**
     * 게스트는 개발 포스트를 삭제할 수 없습니다.
     */
    public function testGuestsCannotDeleteDevelopments() : void
    {
        $development = create(Development::class);

        $this->withExceptionHandling()
             ->delete(route('developments.destroy', $development->id))
             ->assertRedirect(route('login'));
    }

    /**
     * 권한이 없는 사용자는 개발 포스트를 삭제할 수 없습니다.
     */
    public function testUnauthorizedUsersMayNotDeleteDevelopments() : void
    {
        $this->signIn();

        $development = create(Development::class);

        $this->withExceptionHandling()
             ->delete(route('developments.destroy', $development->id))
             ->assertStatus(403);
    }

    /**
     * 권한이 있는 사용자는 개발 포스트를 삭제할 수 있습니다.
     */
    public function testAuthorizedUsersCanDeleteDevelopments() : void
    {
        $this->signIn();

        $development = create(Development::class, ['user_id' => auth()->id()]);

        $this->json('DELETE', route('developments.destroy', $development->id))
             ->assertRedirect(route('developments.index'))
             ->assertSessionHas('flash_notification');

        $this->assertDatabaseMissing('developments', ['id' => $development->id]);
    }

    /**
     * 새로운 개발 포스트를 등록합니다.
     *
     * @param  array  $overrides
     * @return TestResponse
     */
    protected function publishDevelopment(array $overrides = []) : TestResponse
    {
        $this->signIn();

        return $this->withExceptionHandling()
            ->post(
                route('developments.store'),
                make(Development::class, $overrides)->toArray()
            );
    }
}
