<?php

namespace Tests\Feature;

use App\Models\{Comment, Development};
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
     * 사용자는 한개의 개발 포스트를 볼 수 있습니다.
     */
    public function testAUserCanReadASingleDevelopment() : void
    {
        $this->get(route('developments.show', ['development' => $this->development->id]))
             ->assertSee($this->development->title);
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
     * 개발 포스트를 읽을 때마다 조회수를 증가 시킵니다.
     */
    public function testWeRecordANewVisitEachTimeTheDevelopmentIsRead() : void
    {
        $this->assertSame(0, $this->development->visits);

        $this->get(route('developments.show', $this->development->id));

        $this->assertEquals(1, $this->development->fresh()->visits);
    }
}
