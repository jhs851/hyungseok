<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 로그인한 사용자만 아바타를 추가할 수 있습니다.
     */
    public function testOnlyMembersCanAddAvatars() : void
    {
        $this->withExceptionHandling()
             ->post(route('users.avatar.store', create(User::class)->id))
             ->assertRedirect(route('login'));
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
//     public function testAUserMayAddAnAvatarToTheirProfile() : void
//     {
//         $this->signIn();
//
//         Storage::fake();
//
//         $this->post(route('users.avatar.store', auth()->user()->id), [
//             'src' => 'http://via.placeholder.com/64x64',
//         ]);
//
//         tap(auth()->user()->fresh()->avatar_path, function (string $path) {
//             $this->assertNotNull($path);
//
//             Storage::assertExists($path);
//         });
//     }

    /**
     * 로그인 하지 않은 사용자는 아바타를 삭제할 수 없습니다.
     */
    public function testGuestsCannnotDeleteAvatars() : void
    {
        $this->withExceptionHandling()
             ->delete(route('users.avatar.destroy', create(User::class)->id))
             ->assertRedirect(route('login'));
    }

    /**
     * 권한이 없는 사용자는 아바타를 삭제할 수 없습니다.
     */
    public function testUnauthorizeUsersCannotDeleteAvatars() : void
    {
        Storage::fake();

        $image = $this->createFakeImage();

        $this->signIn();

        $user = create(User::class, ['avatar_path' => $image]);

        $this->withExceptionHandling()
             ->delete(route('users.avatar.destroy', $user->id))
             ->assertStatus(403);
    }

    /**
     * 권한이 있는 사용자는 아바타를 삭제할 수 있습니다.
     */
    public function testAUserMayDeleteAnAvatarToTheirProfile() : void
    {
        Storage::fake();

        $image = $this->createFakeImage();

        Storage::assertExists($image);

        $this->signIn(create(User::class, ['avatar_path' => $image]));

        $this->delete(route('users.avatar.destroy', auth()->id()));

        $this->assertNull(auth()->user()->fresh()->avatar_path);

        Storage::assertMissing($image);
    }

    /**
     * 이미지를 만들고 경로를 반환합니다.
     *
     * @return string
     */
    protected function createFakeImage() : string
    {
        $image = UploadedFile::fake()->image('foo.jpg');

        return Storage::put('avatars', $image);
    }
}
