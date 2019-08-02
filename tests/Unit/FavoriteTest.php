<?php

namespace Tests\Unit;

use App\Models\{Development, Favorite, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\{Builder, Relations\MorphTo};
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

    /**
     * 좋아요 모델은 User 모델에 대한 BelongsTo 인스턴스를 반환하는 user 를 가지고 있습니다.
     */
    public function testItHasUser() : void
    {
        $this->assertInstanceOf(User::class, $this->favorite->user);
    }

    /**
     * 좋아요 모델은 좋아요 타입과 id로 그룹화하고 count 를 추가한 쿼리 스코프를 가지고 있습니다.
     */
    public function testItHasScopeCountByFavorited() : void
    {
        // setUp 을 포함한 총 3개의 좋아요를 만들고, 두개는 하나의 글에 좋아요.
        tap(create(Development::class), function (Development $development) {
            $this->signIn();

            $development->favorite();

            $this->signIn(create(User::class));

            $development->favorite();
        });

        // 좋아요는 3개 이지만 group_by 해서 컬렉션은 2개고,
        // group_by 한 컬럼중 favorites_count 가 가장 많은 좋아요의 favorites_count 는 2다.
        tap(Favorite::countByFavorited(), function (Builder $builder) {
            $this->assertEquals(2, $builder->get()->count());

            $this->assertEquals(2, $builder->orderBy('favorites_count', 'desc')->first()->favorites_count);
        });
    }
}
