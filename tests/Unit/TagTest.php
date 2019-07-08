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
     * 태그 모델의 fillable은 이름 입니다.
     */
    public function testTheTagFillableIsName() : void
    {
        $this->assertEquals(['name'], $this->tag->getFillable());
    }
}
