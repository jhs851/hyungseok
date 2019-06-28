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

    /**
     * Body안에 사용자 이름이 언급되고, 언급된 사용자가 존재한다면 a 태그로 감쌉니다.
     */
    public function testItWrapsMentionedUsernamesInTheBodyWithinAnchorTags() : void
    {
        $john = create(User::class, ['name' => 'John']);
        $comment = create(Comment::class, ['body' => 'Hello @John']);
        $otherComment = create(Comment::class, ['body' => 'Hello @Bob']);

        $this->assertEquals(
            'Hello <a href="' . route('users.show', $john->id) . '">@John</a>',
            $comment->body
        );

        $this->assertEquals(
            'Hello @Bob',
            $otherComment->body
        );
    }

    /**
     * 댓글 모델을 변경했을 때 사용자 이름이 언급된다면, a 태그로 감쌉니다.
     */
    public function testItWrapsMentionedUsernamesInTheBodyWhenUpdateCommenttWithinAnchorTags() : void
    {
        $jeong = create(User::class, ['email' => config('auth.admin.email')[0], 'name' => '정형석']);

        $this->signIn($jeong);

        $this->put(route('comments.update', $this->comment->id), ['body' => '안녕 @정형석']);

        $this->assertEquals(
            '안녕 <a href="' . route('users.show', $jeong->id) . '">@정형석</a>',
            $this->comment->fresh()->body
        );
    }
}
