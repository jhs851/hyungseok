<?php

namespace Tests\Feature;

use App\Models\Development;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingDevelopmentsTest extends TestCase
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

        Redis::del('trending_developments');
    }

    /**
     * 개발 포스트를 읽을 때마다 redis에 뷰 카운트를 한개씩 증가시킵니다.
     */
    public function testItIncrementsDevelopmentsScoreEachTimeItIsRead() : void
    {
        $this->assertEmpty(Redis::zrevrange('trending_developments', 0, -1));

        $development = create(Development::class);

        $this->call('GET', route('developments.show', $development->id));

        $trending = Redis::zrevrange('trending_developments', 0, -1);

        $this->assertCount(1, $trending);

        $this->assertEquals($development->title, json_decode($trending[0])->title);
    }
}
