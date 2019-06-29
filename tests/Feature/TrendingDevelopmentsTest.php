<?php

namespace Tests\Feature;

use App\Core\Trending;
use App\Models\Development;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TrendingDevelopmentsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Trending 인스턴스.
     *
     * @var Trending
     */
    protected $trending;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->trending = Trending::reset();
    }

    /**
     * 개발 포스트를 읽을 때마다 redis에 뷰 카운트를 한개씩 증가시킵니다.
     */
    public function testItIncrementsDevelopmentsScoreEachTimeItIsRead() : void
    {
        $this->assertEmpty($this->trending->get());

        $development = create(Development::class);

        $this->call('GET', route('developments.show', $development->id));

        $this->assertCount(1, $trending = $this->trending->get());

        $this->assertEquals($development->title, $trending[0]->title);
    }
}
