<?php

namespace Tests\Feature;

use App\Events\TagCreated;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Event;
use App\Models\{Tag, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BroadcastTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 태그를 생성하면 브로드 캐스트 이벤트를 발생시킵니다.
     *
     * @throws FileNotFoundException
     */
    public function testCreatedTagWhenFireBroadcastEvents() : void
    {
        Event::fake();

        $this->signIn(factory(User::class)->state('admin')->create());

        $tag = make(Tag::class);

        $this->post(route('admin.tags.store', ['name' => $tag->name]));

        Event::assertDispatched(TagCreated::class);
    }
}
