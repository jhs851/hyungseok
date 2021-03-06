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
        $this->signIn(factory(User::class)->state('unconfirmed')->create());

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

    /**
     * 게스트는 댓글을 삭제할 수 없습니다.
     */
    public function testGuestsCannotDeleteComments() : void
    {
        $comment = create(Comment::class);

        $this->withExceptionHandling()
             ->delete(route('comments.destroy', $comment->id))
             ->assertRedirect(route('login'));
    }

    /**
     * 권한이 없는 사용자는 댓글을 삭제할 수 없습니다.
     */
    public function testUnauthorziedUsersCannotDeleteComments() : void
    {
        $this->signIn();

        $comment = create(Comment::class);

        $this->withExceptionHandling()
             ->delete(route('comments.destroy', $comment->id))
             ->assertStatus(403);
    }

    /**
     * 권한이 있는 사용자는 댓글을 삭제할 수 있습니다.
     */
    public function testAuthorziedUsersCanDeleteComments() : void
    {
        $this->signIn();

        $comment = create(Comment::class, ['user_id' => auth()->id()]);

        $this->delete(route('comments.destroy', $comment->id));

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /**
     * 게스트는 댓글을 변경할 수 없습니다.
     */
    public function testGuestsCannotUpdateComments() : void
    {
        $comment = create(Comment::class);

        $this->withExceptionHandling()
             ->put(route('comments.update', $comment->id))
             ->assertRedirect(route('login'));
    }

    /**
     * 권한이 없는 사용자는 댓글을 변경할 수 없습니다.
     */
    public function testUnauthorziedUsersCannotUpdateComments() : void
    {
        $this->signIn();

        $comment = create(Comment::class);

        $this->withExceptionHandling()
             ->put(route('comments.update', $comment->id), ['body' => 'Updated'])
             ->assertStatus(403);
    }

    /**
     * 권한이 있는 사용자는 댓글을 변경할 수 있습니다.
     */
    public function testAuthorziedUsersCanUpdateComments() : void
    {
        $this->signIn();

        $comment = create(Comment::class, ['user_id' => auth()->id()]);

        $updatedComment = 'You been changed, fool.';

        $this->put(route('comments.update', $comment->id), [
            'body' => $updatedComment,
        ]);

        $this->assertDatabaseHas('comments', [
            'id'   => $comment->id,
            'body' => $updatedComment,
        ]);
    }

    /**
     * 사용자는 1분당 최대 한개의 댓글만 저장할 수 있습니다.
     */
    public function testUsersMayOnlyCommentAMaximumOfOncePerMinute() : void
    {
        $this->signIn();

        $comment = make(Comment::class, ['body' => 'My simple comment.']);

        $this->post(route('comments.store', $this->development->id), $comment->toArray())
             ->assertStatus(200);

        $message = $this->withExceptionHandling()
             ->postJson(route('comments.store', $this->development->id), $comment->toArray())
             ->assertStatus(429)
             ->json('message');

        $this->assertEquals(trans('comments.too_many_requests'), $message);
    }
}
