<?php

namespace Tests\Unit;

use App\Models\Activity;
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

        $this->activity = create(Activity::class);
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
}
