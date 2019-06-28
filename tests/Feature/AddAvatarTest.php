<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
             ->post(route('users.avatar', 1))
             ->assertRedirect(route('login'));
    }

    /**
     * 아바타는 반드시 이미지로 공급되어야 합니다.
     */
    public function testAValidAvatarMustBeProvided() : void
    {
        $this->signIn();

        $this->withExceptionHandling()
             ->post(route('users.avatar', auth()->user()->id), [
                'avatar' => 'not-an_image',
            ])
            ->assertSessionHasErrors('avatar');
    }

    /**
     * 사용자는 아바타를 추가할 수 있습니다.
     */
    public function testAUserMayAddAnAvatarToTheirProfile() : void
    {
        $this->signIn();

        Storage::fake('public');

        $this->post(route('users.avatar', auth()->user()->id), [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $this->assertEquals('avatars/' . $file->hashName(), auth()->user()->fresh()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
