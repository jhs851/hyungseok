<?php

namespace Tests\Feature;

use App\Models\{Comment, Development, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadDevelopmentTest extends TestCase
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
     * 사용자는 모든 개발 포스트를 볼 수 있습니다.
     */
    public function /*test*/AUserCanViewAllDevelopments() : void
    {
        $this->get(route('developments.index'))
             ->assertSee($this->development->title);
    }

    /**
     * 사용자는 한개의 개발 포스트를 볼 수 있습니다.
     */
    public function testAUserCanReadASingleDevelopment() : void
    {
        $this->get(route('developments.show', ['development' => $this->development->id]))
             ->assertSee($this->development->title);
    }

    /**
     * 사용자는 개발 포스트의 어떠한 작성자에 대해 필터할 수 있습니다.
     */
    public function /*test*/AUserCanFilterDevelopmentsByAnyUsername() : void
    {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));

        $developmentByJohn = create(Development::class, ['user_id' => auth()->id()]);
        $developmentNotByJohn = create(Development::class);

        $this->get(route('developments.index', ['by' => 'JohnDoe']))
            ->assertSee($developmentByJohn->title)
            ->assertDontSee($developmentNotByJohn->title);
    }

    /**
     * 개발 포스트와 연결 돼있는 댓글들은 사용자가 읽을 수 있습니다.
     */
    public function testAUserCanReadCommentsThatAreAssociatedWithADevelopment() : void
    {
        $comment = create(Comment::class, ['development_id' => $this->development->id]);

        $this->get(route('developments.show', $this->development->id))
            ->assertSee($comment->body);
    }

    /**
     * 사용자는 인기있는 개발 포스트를 필터링 할 수 있습니다.
     */
    public function /*test*/AUserCanFilterDevelopmentsByPopularity() : void
    {
        $DevelopmentWithTwoComments = create(Development::class);
        create(Comment::class, ['development_id' => $DevelopmentWithTwoComments], 2);

        $threadWithThreeReplies = create(Development::class);
        create(Comment::class, ['development_id' => $threadWithThreeReplies], 3);

        $response = $this->getJson(route('developments.index', ['popularity' => 1]))->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'comments_count'));
    }

    /**
     * 개발 포스트를 읽을 때마다 조회수를 증가 시킵니다.
     */
    public function testWeRecordANewVisitEachTimeTheDevelopmentIsRead() : void
    {
        $this->assertSame(0, $this->development->visits);

        $this->get(route('developments.show', $this->development->id));

        $this->assertEquals(1, $this->development->fresh()->visits);
    }
}
