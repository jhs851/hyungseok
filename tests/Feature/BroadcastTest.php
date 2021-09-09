<?php

namespace Tests\Feature;

use App\Events\TagCreated;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use App\Models\{Tag, User};
use Carbon\Carbon;
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
        $this->signIn(factory(User::class)->state('admin')->create());

        $tag = make(Tag::class);

        $this->post(route('admin.tags.store', ['name' => $tag->name]));

        $logPath = storage_path('logs/laravel.log');
        $logFile = preg_split('/\[[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}] testing\.INFO:/', File::get($logPath));

        if (count($logFile)) {
            $supposedLastEventLogged = $logFile[count($logFile) - 1];

            $this->assertContains('Broadcasting [', $supposedLastEventLogged);

            $this->assertContains('Broadcasting [' . TagCreated::class . ']', $supposedLastEventLogged);

            $this->assertContains('Broadcasting [' . TagCreated::class . '] on channels [tags]', $supposedLastEventLogged);
        } else {
            $this->fail('No informations found in the file log \'' . $logPath . '\'.');
        }
    }
}
