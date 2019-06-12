<?php

namespace Tests\Unit;

use App\Models\{Development, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DevelopmentTest extends TestCase
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
     * 개발 모델의 fillable은 제목과 본문입니다.
     */
    public function testTheDevelopmentFillableIsTheTitleAndBody() : void
    {
        $this->assertEquals(['title', 'body'], $this->development->getFillable());
    }

    /**
     * 개발 모델을 불러오면 제목과 본문만 보입니다.
     */
    public function testWhenCallDevelopmentOnlyTheTitleAndBodyAreVisible() : void
    {
        $this->assertEquals(['title', 'body'], array_keys($this->development->toArray()));
    }

    /**
     * 개발 모델은 사용자와 연결 돼있습니다.
     */
    public function testADevelopmentHasUser() : void
    {
        $this->assertInstanceOf(User::class, $this->development->user);
    }
}
