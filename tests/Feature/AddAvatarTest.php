<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Provider\Image;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 로그인한 사용자만 아바타를 추가할 수 있습니다.
     */
    public function testOnlyMembersCanAddAvatars() : void
    {
        $this->withExceptionHandling()
             ->post(route('users.avatar.store', create(User::class)->id))
             ->assertStatus(403);
    }

    /**
     * 권한이 없는 사용자는 아바타를 추가할 수 없습니다.
     */
    public function testUnauthorizeUserCannotAddAvatars() : void
    {
        $this->signIn();

        $this->withExceptionHandling()
             ->post(route('users.avatar.store', create(User::class)->id))
             ->assertStatus(403);
    }

    /**
     * 아바타는 반드시 src값이 있어야 합니다.
     */
    public function testAValidAvatarMustBeProvided() : void
    {
        $this->signIn();

        $this->withExceptionHandling()
             ->post(route('users.avatar.store', auth()->user()->id))
            ->assertSessionHasErrors('src');
    }

    /**
     * 사용자는 아바타를 추가할 수 있습니다.
     */
    public function testAUserMayAddAnAvatarToTheirProfile() : void
    {
        $this->signIn();

        $this->post(route('users.avatar.store', auth()->user()->id), [
            'src' => Image::imageUrl(64, 64),
        ]);

        tap(auth()->user()->fresh()->avatar_path, function ($path) {
            $this->assertNotNull($path);

            $this->assertFileExists(public_path($path));

            File::delete(public_path($path));
        });
    }
}
