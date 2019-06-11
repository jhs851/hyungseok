<?php

namespace Tests\Feature;

use App\Models\Development;
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
}
