<?php

namespace Tests\Feature;

use App\Models\{Comment, Development, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Development 모델 인스턴스.
     *
     * @var Development
     */
    protected $development;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->development = create(Development::class);
    }

    /**
     * 게스트는 댓글을 작성할 수 없습니다.
     */
    public function testUnauthenticatedUserMayNotAddComments() : void
    {
        $this->withExceptionHandling()
             ->post(route('comments.store', 1), [])
             ->assertRedirect(route('login'));
    }

    /**
     * 이메일 인증을 하지 않은 유저는 개발 포스트에 참여할 수 없습니다.
     */
    public function testNewUsersMustFirstConfirmTheirEmailBeforeCreatingComments() : void
    {
        $this->signIn(create(User::class, ['email_verified_at' => null]));

        $this->post(route('comments.store', ['development' => $this->development->id]), make(Comment::class)->toArray())
             ->assertRedirect(route('verification.notice'))
             ->assertSessionHas('flash_notification');
    }

    /**
     * 인증된 사용자는 개발 포스트에 참여할 수 있습니다.
     */
    public function testAnAuthenticatedUserMayParticipateInForumDevelopments()
    {
        $this->signIn();

        $comment = make(Comment::class);

        $this->post(
            route('comments.store', $this->development->id),
            $comment->toArray()
        );

        $this->get(route('developments.show', ['development' => $this->development->id]))
             ->assertSee($comment->body);
    }
}
