<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadImagesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 게스트는 이미지를 업로드 할 수 없습니다.
     */
    public function testGuestsCannotUploadImages() : void
    {
        $this->withExceptionHandling()
             ->post(route('images.store'), ['image' => UploadedFile::fake()->image('foobar.jpg')])
             ->assertStatus(403);
    }
    
    /**
     * 이메일 미인증 사용자는 이미지를 업로드 할 수 없습니다.
     */
    public function testEmailUnauthenticatedUsersCannotUploadImages() : void
    {
        $this->signIn(factory(User::class)->state('unconfirmed')->create());

        $this->withExceptionHandling()
            ->post(route('images.store'), ['image' => UploadedFile::fake()->image('foobar.jpg')])
            ->assertStatus(403);
    }

    /**
     * 이미지를 업로드 할 때 image 값은 필 수 입니다.
     */
    public function testWhenUploadingAnImageTheImageValueIsRequired() : void
    {
        $this->signIn(create(User::class));

        $this->withExceptionHandling()
             ->post(route('images.store'), ['image' => ''])
             ->assertSessionHasErrors('image');
    }

    /**
     * 사용자는 이미지를 업로드 할 수 있습니다.
     */
    public function testUsersCanUploadImages() : void
    {
        $this->signIn(create(User::class));

        Storage::fake();

        $this->post(route('images.store'), ['image' => $file = UploadedFile::fake()->image('foobar.jpg')]);

        Storage::assertExists('images/' . $file->hashName());
    }
}
