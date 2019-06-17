<?php

namespace Tests\Feature;

use App\Models\{Development, User};
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
    public function testAUserCanViewAllDevelopments() : void
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
    public function AUserCanFilterDevelopmentsByAnyUsername() : void
    {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));

        $developmentByJohn = create(Development::class, ['user_id' => auth()->id()]);
        $developmentNotByJohn = create(Development::class);

        $this->get(route('developments.index', ['by' => 'JohnDoe']))
            ->assertSee($developmentByJohn->title)
            ->assertDontSee($developmentNotByJohn->title);
    }
}
