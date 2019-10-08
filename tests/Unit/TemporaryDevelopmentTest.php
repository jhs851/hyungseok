<?php

namespace Tests\Unit;

use App\Models\TemporaryDevelopment;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TemporaryDevelopmentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Development 인스턴스.
     *
     * @var Development
     */
    protected $temporaryDevelopment;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->temporaryDevelopment = create(TemporaryDevelopment::class);
    }

    /**
     * 임시 개발 모델의 fillable은 개발포스트 ID와 제목과 본문 입니다.
     */
    public function testItFillableIsTheDevelopmentIdAndTitleAndBody() : void
    {
        $this->assertEquals(['development_id', 'title', 'body'], $this->temporaryDevelopment->getFillable());
    }
}
