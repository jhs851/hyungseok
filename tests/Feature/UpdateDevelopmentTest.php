<?php

namespace Tests\Feature;

use App\Models\{Development, Tag};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateDevelopmentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->signIn();
    }

    /**
     * 개발 블로그를 변경할 때 제목 값은 필수 항목입니다.
     */
    public function testADevelopmentRequiresATitleToBeUpdated() : void
    {
        $development = create(Development::class, ['user_id' => auth()->id()]);

        $this->withExceptionHandling()
             ->put(route('developments.update', $development->id), ['title' => ''])
             ->assertSessionHasErrors('title');
    }

    /**
     * 개발 블로그를 변경할 때 본문 값은 필수 항목입니다.
     */
    public function testADevelopmentRequiresABodyToBeUpdated() : void
    {
        $development = create(Development::class, ['user_id' => auth()->id()]);

        $this->withExceptionHandling()
            ->put(route('developments.update', $development->id), ['title' => 'Changed', 'body' => ''])
            ->assertSessionHasErrors('body');
    }

    /**
     * 권한이 없는 사용자는 개발 블로그를 변경할 수 없습니다.
     */
    public function testUnauthorizedUsersMayNotUpdateDevelopments() : void
    {
        $development = create(Development::class);

        $this->withExceptionHandling()
             ->put(route('developments.update', $development->id), ['title' => 'Changed', 'body' => 'Change body'])
             ->assertStatus(403);
    }

    /**
     * 글쓴이는 개발 블로그를 변경할 수 있습니다.
     */
    public function testADevelopmentCanBeUpdatedByItsCreator() : void
    {
        $tags = create(Tag::class, [], 3);
        $development = create(Development::class, ['user_id' => auth()->id()]);

        $this->put(route('developments.update', $development->id), [
            'title' => 'Changed',
            'body'  => 'Changed body.',
            'tags'  => $tags->pluck('id')->toArray(),
        ]);

        tap($development->fresh(), function($development) {
            $this->assertEquals('Changed', $development->title);
            $this->assertEquals('Changed body.', $development->body);
        });
    }
}
