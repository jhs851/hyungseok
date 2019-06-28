<?php

namespace Tests\Unit;

use App\Models\{Comment, Development, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 댓글 모델 인스턴스.
     *
     * @var Comment
     */
    protected $comment;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->comment = create(Comment::class);
    }

    /**
     * 댓글 모델의 fillable은 작성자 id와 본문 입니다.
     */
    public function testTheCommentFillableIsTheUserIdAndBody() : void
    {
        $this->assertEquals(['user_id', 'body'], $this->comment->getFillable());
    }

    /**
     * 댓글은 작성자를 가지고 있습니다.
     */
    public function testItHasOnUser() : void
    {
        $this->assertInstanceOf(User::class, $this->comment->user);
    }

    /**
     * 댓글은 개발 포스트를 가지고 있습니다.
     */
    public function testItHasOnDevelopment() : void
    {
        $this->assertInstanceOf(Development::class, $this->comment->development);
    }

    /**
     * 댓글 모델은 Body에서 언급된 모든 사용자를 감지할 수 있습니다.
     */
    public function testItCanDetectAllMentionedUsersInTheBody() : void
    {
        $comment = create(Comment::class, ['body' => '@JaneDoe wants to talk to @JohnDoe']);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $comment->mentionedUsers());
    }
}
