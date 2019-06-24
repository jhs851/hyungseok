<?php

namespace Tests\Unit;

use App\Models\{Activity, Comment, Development, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Activty 인스턴스.
     *
     * @var Activity
     */
    protected $activity;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->signIn();

        $this->activity = create(Development::class)->activities->first();
    }

    /**
     * 활동 모델의 fillable은 타입과 사용자 id 입니다.
     */
    public function testItFillableIsTheTypeAndUserId() : void
    {
        $this->assertEquals(['type', 'user_id'], $this->activity->getFillable());
    }

    /**
     * 활동 모델은 MorphTo 인스턴스를 반환하는 subject 를 가지고 있습니다.
     */
    public function testItHasSubject() : void
    {
        $this->assertInstanceOf(MorphTo::class, $this->activity->subject());
    }

    /**
     * 활동 모델은 회원을 가지고 있습니다.
     */
    public function testItHasUser() : void
    {
        $this->assertInstanceOf(User::class, $this->activity->user);
    }

    /**
     * 활동 모델은 모든 사용자에 대한 피드를 가져올 수 있습니다.
     */
    public function testItFetchesAFeedForAnyUser() : void
    {
        $development = create(Development::class, ['user_id' => auth()->id()]);
        create(Comment::class, ['development_id' => $development->id, 'user_id' => auth()->id()]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            'created_development'
        ));

        $this->assertTrue($feed->keys()->contains(
            'created_comment'
        ));
    }
}
