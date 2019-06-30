<?php

namespace Tests\Feature;

use App\Models\{Comment, Development, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BestCommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 개발 포스트의 작성자는 베스트 댓글로 마크할 수 있습니다.
     */
    public function testADevelopmentCreatorMayMarkCommentAsTheBestComment() : void
    {
        $this->signIn();

        $development = create(Development::class, ['user_id' => auth()->id()]);

        $comments = create(Comment::class, ['development_id' => $development->id], 2);

        $this->assertFalse($comments[1]->isBest);

        $this->postJson(route('best-comments.store', $comments[1]->id));

        $this->assertTrue($comments[1]->fresh()->isBest);
    }

    /**
     * 오직 개발 포스트의 작성자만이 베스트 댓글로 마크할 수 있습니다.
     */
    public function testOnlyTheDevelopmentCreatorMayMarkACommentAsBest() : void
    {
        $this->signIn();

        $development = create(Development::class, ['user_id' => auth()->id()]);

        $comments = create(Comment::class, ['development_id' => $development->id], 2);

        $this->signIn(create(User::class));

        $this->withExceptionHandling()
             ->post(route('best-comments.store', $comments[1]->id))
             ->assertStatus(403);
    }

    /**
     * 베스트 댓글이 삭제되면 개발이 적절하게 업데이트 됩니다.
     */
    public function testIfABestCommentIsDeletedThenTheDevelopmentIsProperlyUpdatedToReflectThat() : void
    {
        $this->signIn();

        $comment = create(Comment::class, ['user_id' => auth()->id()]);

        $comment->development->markBestComment($comment);

        $this->deleteJson(route('comments.destroy', $comment->id));

        $this->assertNull($comment->development->fresh()->best_reply_id);
    }
}
