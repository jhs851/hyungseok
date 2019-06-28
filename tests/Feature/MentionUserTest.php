<?php

namespace Tests\Feature;

use App\Models\{Comment, Development, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MentionUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 댓글안에 사용자를 언급하면 알림을 보냅니다.
     */
    public function testMentionedUsersInACommentAreNotified() : void
    {
        $john = create(User::class, ['name' => 'JohnDoe']);

        $this->signIn($john);

        $jane = create(User::class, ['name' => 'JaneDoe']);

        $development = create(Development::class);

        $comment = make(Comment::class, ['body' => '@JaneDoe look at this. @Bob']);

        $this->post(route('comments.store', $development->id), $comment->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}