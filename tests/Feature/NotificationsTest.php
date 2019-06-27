<?php

namespace Tests\Feature;

use App\Models\{Development, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

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
    }

    /**
     * 개발 포스트에 새로운 댓글을 포스트 작성자가 아닌 사용자가 작성했을 때 알림을 전송합니다.
     */
    public function testANotificationIsPreparedWhenADevelopmentReceivesANewCommentThatIsNotByTheCurrentUser() : void
    {
        $development = create(Development::class, ['user_id' => auth()->id()]);

        $this->assertCount(0, auth()->user()->notifications);

        $development->addComment([
            'user_id' => auth()->id(),
            'body' => 'Some reply here',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $development->addComment([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /**
     * 사용자가 읽지 않은 알림을 가져올 수 있습니다.
     */
    public function testAUserCanFetchTheirUnreadNotifications() : void
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson(route('notifications.index', auth()->id()))->json()
        );
    }

    /**
     * 사용자는 알림을 읽은 것으로 마크할 수 있습니다.
     */
    public function testAUserCanMarkANotificationAsRead() : void
    {
        create(DatabaseNotification::class);

        tap(auth()->user(), function (User $user) {
            $this->assertCount(1, $user->unreadNotifications);

            $id = $user->unreadNotifications()->value('id');

            $this->delete(route('notifications.destroy', [
                'user'         => $user->id,
                'notification' => $id,
            ]));

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}