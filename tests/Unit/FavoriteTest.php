<?php

namespace Tests\Unit;

use App\Models\Favorite;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Favorite 모델 인스턴스.
     *
     * @var Favorite
     */
    protected $favorite;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->favorite = create(Favorite::class);
    }

    /**
     * 좋아요 모델의 fillable은 사용자 id 입니다.
     */
    public function testTheFavoriteFillableIsTheUserId() : void
    {
        $this->assertEquals(['user_id'], $this->favorite->getFillable());
    }

    /**
     * 좋아요 모델은 MorphTo 인스턴스를 반환하는 favorited 를 가지고 있습니다.
     */
    public function testItHasFavorited() : void
    {
        $this->assertInstanceOf(MorphTo::class, $this->favorite->favorited());
    }
}
