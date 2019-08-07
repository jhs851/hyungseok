<?php

namespace Tests\Unit;

use App\Events\DevelopmentRecivedNewComment;
use App\Models\{Comment, Development, Tag, User};
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
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
     * 개발 모델의 fillable은 제목과 본문과 베스트 댓글 id 입니다.
     */
    public function testTheDevelopmentFillableIsTheTitleAndBodyAndBestCommentId() : void
    {
        $this->assertEquals(['title', 'body', 'best_comment_id'], $this->development->getFillable());
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
     * 개발 모델은 태그를 가지고 있습니다.
     */
    public function testADevelopmentHasTags() : void
    {
        $this->assertInstanceOf(Collection::class, $this->development->tags);
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

        $this->assertCount(1, $this->development->fresh()->favorites);
    }

    /**
     * 개발 모델을 삭제할 때 하위 댓글들을 모두 삭제합니다.
     */
    public function testWhenDeleteADevelopmentModelDeleteAllSubComments() : void
    {
        $comment = create(Comment::class, ['development_id' => $this->development->id]);

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);

        $this->development->delete();

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /**
     * 개발 모델을 삭제할 때 태그들을 분리합니다.
     */
    public function testWhenDeleteADevelopmentModelDetachAllTags() : void
    {
        $tag = create(Tag::class);

        $this->development->tags()->sync($tag->id);

        $this->assertDatabaseHas('development_tag', ['development_id' => $this->development->id, 'tag_id' => $tag->id]);

        $this->development->delete();

        $this->assertDatabaseMissing('development_tag', ['development_id' => $this->development->id, 'tag_id' => $tag->id]);
    }

    /**
     * 개발 포스트에 댓글이 추가되면 이벤트를 실행합니다.
     */
    public function testItFireEventWhenACommentIsAdded() : void
    {
        Event::fake();

        $this->development->addComment([
            'user_id' => 2,
            'body' => 'Event testing...',
        ]);

        Event::assertDispatched(DevelopmentRecivedNewComment::class);
    }

    /**
     * 개발 모델은 댓글을 베스트 댓글로 마크할 수 있습니다.
     */
    public function testItCanMayMarkCommentAsTheBestComment() : void
    {
        $comment = create(Comment::class, ['development_id' => $this->development->id]);

        $this->assertFalse($comment->isBest);

        $this->development->markBestComment($comment);

        $this->assertTrue($comment->fresh()->isBest);
    }

    /**
     * 개발 모델을 스카웃에 인덱싱할 때 created_at_timestamp 키를 추가하고 body 키를 삭제한 후에 임포트 합니다.
     */
    public function testWhenindexingAItInTheScountAddTheCreatedAtTimestampThenImportIt() : void
    {
        $this->assertArrayHasKey('created_at_timestamp', $this->development->toSearchableArray());

        $this->assertArrayNotHasKey('body', $this->development->toSearchableArray());
    }

    /**
     * 개발 모델은 주어진 Carbon 인스턴스(year, month)의 글만 가져올 수 있습니다.
     */
    public function testItCanOnlyBringBackPostsOfAGivenMonth() : void
    {
        $subMonth = Carbon::now()->subMonthsNoOverflow();

        create(Development::class, ['created_at' => $subMonth]);

        $this->assertCount(2, Development::all());

        $this->assertCount(1, Development::monthlies()->get());

        $this->assertCount(1, Development::monthlies($subMonth)->get());
    }

    /**
     * 개발 모델은 일별로 그룹화하고 해당 날짜에 해당하는 포스트의 수를 반환할 수 있습니다.
     */
    public function testItCanBeGroupByDayAndReturnedTheCountOfPostsCorrespondingToThatDate() : void
    {
        $this->development->delete();
        $subDays = Carbon::now()->setDay(1);
        $yesterday = Carbon::now()->setDay(2);
        $now = Carbon::now()->setDay(3);

        // 엊그제 개발 포스트는 4개
        create(Development::class, ['created_at' => $subDays], 4);

        // 어제의 개발 포스트는 2개
        create(Development::class, ['created_at' => $yesterday], 2);

        // 오늘 개발 포스트는 2개
        create(Development::class, ['created_at' => $now], 2);

        $this->assertEquals([$subDays->day, $yesterday->day, $now->day], Development::countsByDays()->get()->pluck('day')->toArray());

        $this->assertEquals([4, 2, 2], Development::countsByDays()->get()->pluck('count')->toArray());
    }
}
