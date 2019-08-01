<?php

namespace Tests\Unit;

use App\Models\Tag;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->tag = create(Tag::class);
    }

    /**
     * 태그 모델의 fillable은 이름과 mentions 입니다.
     */
    public function testTheTagFillableIsName() : void
    {
        $this->assertEquals(['name', 'mentions'], $this->tag->getFillable());
    }

    /**
     * 태그 모델은 개발 모델과 분리할 수 있는 detach 메서드를 가지고 있습니다.
     */
    public function testTheTagModelHasADetachMethodThatCanBeSeparatedFromTheDevelopmentModel() : void
    {
        $this->assertTrue(method_exists(Tag::class, 'detach'));
    }

    /**
     * 태그 모델을 스카웃에 인덱싱할 때 created_at_timestamp 키를 추가하고 임포트 합니다.
     */
    public function testWhenindexingAItInTheScountAddTheCreatedAtTimestampThenImportIt() : void
    {
        $this->assertArrayHasKey('created_at_timestamp', $this->tag->toSearchableArray());
    }
}
