<?php

namespace Tests\Feature;

use App\Models\{Development, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Development 모델 인스턴스.
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
     * 게스트는 어느곳에도 좋아요를 할 수 없습니다.
     */
    public function testGuestsCanNotFavoriteAnything() : void
    {
        $this->withExceptionHandling()
             ->post(route('favorites.store', ['comment' => $this->development->id]))
             ->assertRedirect(route('login'));
    }

    /**
     * 이메일 인증을 하지 않은 유저는 좋아요를 할 수 없습니다.
     */
    public function testNewUsersMustFirstConfirmTheirEmailBeforeCreatingFavorite() : void
    {
        $this->signIn(factory(User::class)->state('unconfirmed')->create());

        $this->post(route('favorites.store', ['development' => $this->development->id]))
             ->assertRedirect(route('verification.notice'))
             ->assertSessionHas('flash_notification');
    }

    /**
     * 인증이 된 사용자는 모든 개발 포스트에 좋아요를 할 수 있습니다.
     */
    public function testAnAuthenticatedUserCanFavoriteAnyDevelopment() : void
    {
        $this->signIn();

        $this->post(route('favorites.store', ['development' => $this->development->id]));

        $this->assertCount(1, $this->development->fresh()->favorites);
    }

    /**
     * 인증이 된 사용자는 모든 개발 포스트에 좋아요를 취소할 수 있습니다.
     */
    public function testAnAuthenticatedUserCanUnfavoriteAnyDevelopment() : void
    {
        $this->signIn();

        $this->development->favorite();

        $this->assertCount(1, $this->development->fresh()->favorites);

        $this->delete(route('favorites.destroy', $this->development->id));

        $this->assertCount(0, $this->development->fresh()->favorites);
    }


    /**
     * 인증이 된 사용자는 한개의 개발 포스트에 오직 한번만 좋아요를 할 수 있습니다.
     */
    public function testAnAuthenticatedUserMayOnlyFavoriteADevelopmentOnce() : void
    {
        $this->signIn();

        try {
            $this->post(route('favorites.store', $this->development->id));
            $this->post(route('favorites.store', $this->development->id));
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $this->development->fresh()->favorites);
    }

    /**
     * Favoritable을 소유하고 있는 모델은 자동으로 favoritesCount, isFavorited 속성을 가질 수 있습니다.
     */
    public function testModelsThatOwnFavoritableCanAutomaticallyHaveFavoritesCountIsFavoritedAttributes() : void
    {
        $this->assertNotNull($this->development->favoritesCount);
        $this->assertNotNull($this->development->isFavorited);
    }
}
