<?php

namespace Tests\Feature;

use App\Models\{Activity, Comment, Development};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RecordActivitiesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 개발 포스트가 생성 됬을 때 활동을 저장합니다.
     */
    public function testItRecordsActivityWhenADevelopmentIsCreated() : void
    {
        $this->signIn();

        $development = create(Development::class);

        $this->assertDatabaseHas('activities', [
            'type'         => 'created_development',
            'user_id'      => auth()->id(),
            'subject_id'   => $development->id,
            'subject_type' => Development::class,
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $development->id);
    }

    /**
     * 댓글이 생성 됬을 때 활동 내역을 저장합니다.
     */
    public function testItRecordsActivityWhenACommentIsCreated() : void
    {
        $this->signIn();

        create(Comment::class);

        $this->assertEquals(2, Activity::count());
    }

    /**
     * 개발 포스트에 좋아요를 했을 때 활동 내역을 저장합니다.
     */
    public function testItRecordsActivityWhenAFavoriteOnDevelopment() : void
    {
        $this->signIn();

        create(Development::class)->favorite();

        $this->assertEquals(2, Activity::count(2));
    }
}
