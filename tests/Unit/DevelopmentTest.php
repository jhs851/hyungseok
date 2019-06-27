<?php

namespace Tests\Unit;

use App\Models\{Comment, Development, User};
use App\Notifications\DevelopmentWasUpdated;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DevelopmentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Development 인스턴스.
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
     * 개발 모델의 fillable은 제목과 본문입니다.
     */
    public function testTheDevelopmentFillableIsTheTitleAndBody() : void
    {
        $this->assertEquals(['title', 'body'], $this->development->getFillable());
    }

    /**
     * 개발 모델은 사용자와 연결 돼있습니다.
     */
    public function testADevelopmentHasUser() : void
    {
        $this->assertInstanceOf(User::class, $this->development->user);
    }

    /**
     * 개발 모델은 댓글을 가지고 있습니다.
     */
    public function testADevelopmentHasComments() : void
    {
        $this->assertInstanceOf(Collection::class, $this->development->comments);
    }

    /**
     * 개발 모델은 댓글을 추가할 수 있습니다.
     */
    public function testADevelopmentCanAddComment() : void
    {
        $this->development->addComment([
            'user_id' => 1,
            'body' => 'Foobar',
        ]);

        $this->assertCount(1, $this->development->comments);
    }

    /**
     * 개발 모델은 좋아요를 가지고 있습니다.
     */
    public function testItHasFavorites() : void
    {
        $this->assertInstanceOf(Collection::class, $this->development->favorites);
    }

    /**
     * 개발 모델글은 좋아요를 추가할 수 있습니다.
     */
    public function testCanCreateFavorites() : void
    {
        $this->signIn();

        $this->development->favorite();

        $this->assertCount(1, $this->development->favorites);
    }

    /**
     * 개발 모델을 삭제할 때 하위 댓글들을 모두 삭제합니다.
     */
    public function testWhenDeleteADevelopmentModelDeleteAllSubComments()
    {
        $comment = create(Comment::class, ['development_id' => $this->development->id]);

        $this->assertDatabaseHas('comments', $comment->toArray());

        $this->development->delete();

        $this->assertDatabaseMissing('comments', $comment->toArray());
    }

    /**
     * 개발 포스트에 댓글이 추가되면 알림을 보냅니다.
     */
    public function testItNotifiesWhenACommentIsAdded() : void
    {
        Notification::fake();

        $this->signIn()
            ->development
            ->addComment([
                'user_id' => 2,
                'body' => 'Foobar',
            ]);

        Notification::assertSentTo($this->development->user, DevelopmentWasUpdated::class);
    }
}
