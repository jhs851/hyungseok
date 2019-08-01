<?php

namespace Tests\Feature;

use App\Models\{Development, DevelopmentTag, Tag, User};
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TaggingTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Tag 인스턴스.
     *
     * @var Tag
     */
    protected $tag;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->tag = create(Tag::class);
    }

    /**
     * 태그들을 가져올 수 있습니다.
     */
    public function testCanImportTags() : void
    {
        $tags = create(Tag::class, [], 2);

        $response = $this->get(route('api.tags.index'))->json();

        $this->assertCount($tags->count() + 1, $response);
    }

    /**
     * 피벗 모델(DevelopmentTag) 은 Tag 모델을 불러 올 수 있습니다.
     */
    public function testDevelopmentTagModelCanBeImportATagModel() : void
    {
        $this->attachTagFromDevelopments();

        $this->assertInstanceOf(Tag::class, Development::first()->tags->first()->pivot->tag);
    }

    /**
     * 개발 모델에서 태그를 언급하면 tags.mentions 가 increment 됩니다.
     */
    public function testIfReferToTagsInTheDevelopmentModelTagsMentionsAreIncrement() : void
    {
        $this->attachTagFromDevelopments();

        $this->assertEquals(3, $this->tag->fresh()->mentions);
    }

    /**
     * 개발 모델에서 태그를 분리하면 tags.mentions가 decrement 됩니다.
     */
    public function testIfDetachTagsFromTheDevelopmentModelTagsMentionsAreDecrement() : void
    {
        $this->attachTagFromDevelopments();

        $this->assertEquals(3, $this->tag->fresh()->mentions);

        Development::first()->delete();

        $this->assertEquals(2, $this->tag->fresh()->mentions);

        $otherTag = create(Tag::class);

        $this->put(route('developments.update', Development::first()->id), [
            'title' => 'Updated',
            'body' => 'Updated',
            'tags' => [$otherTag->id],
        ]);

        $this->assertEquals(1, $this->tag->fresh()->mentions);
    }

    /**
     * 게스트는 태그를 생성, 수정, 삭제 할 수 없습니다.
     */
    public function testGuestsCannotCreateModifyOrDeleteTags() : void
    {
        $this->withExceptionHandling()
             ->post(route('admin.tags.store'))
             ->assertRedirect(route('admin.login'));

        $this->withExceptionHandling()
             ->put(route('admin.tags.update', $this->tag->id))
             ->assertRedirect(route('admin.login'));

        $this->withExceptionHandling()
             ->put(route('admin.tags.destroy', $this->tag->id))
             ->assertRedirect(route('admin.login'));
    }

    /**
     * 일반 회원은 태그를 생성, 수정, 삭제 할 수 없습니다.
     */
    public function testGeneralUsersCannotCreateModifyOrDeleteTags() : void
    {
        $this->signIn();

        $this->withExceptionHandling()
             ->post(route('admin.tags.store'))
             ->assertStatus(401);

        $this->withExceptionHandling()
             ->put(route('admin.tags.update', $this->tag->id))
             ->assertStatus(401);

        $this->withExceptionHandling()
             ->put(route('admin.tags.destroy', $this->tag->id))
             ->assertStatus(401);
    }

    /**
     * 관리자는 태그를 생성, 수정, 삭제 할 수 있습니다.
     */
    public function testAdministratorCanCreateModifyOrDeleteTags() : void
    {
        $this->signIn(factory(User::class)->state('admin')->create());

        $tag = make(Tag::class, ['name' => 'Hello!!!']);

        $this->post(route('admin.tags.store', $tag->toArray()));

        $this->assertDatabaseHas('tags', ['name' => 'Hello!!!']);

        $this->put(route('admin.tags.update', $this->tag->id), ['name' => 'Updated']);

        $this->assertDatabaseHas('tags', [
            'id' => $this->tag->id,
            'name' => 'Updated',
        ]);

        $this->delete(route('admin.tags.destroy', $this->tag->id));

        $this->assertDatabaseMissing('tags', ['name' => $this->tag->id]);
    }

    /**
     * 태그를 생성하거나 수정할 때 이름 값은 필수 입니다.
     */
    public function testATagRequiresAName() : void
    {
        $this->signIn(factory(User::class)->state('admin')->create());

        $this->withExceptionHandling()
             ->post(route('admin.tags.store'))
             ->assertSessionHasErrors('name');

        $this->withExceptionHandling()
             ->put(route('admin.tags.update', $this->tag->id), ['name' => ''])
             ->assertSessionHasErrors('name');
    }

    /**
     * 태그를 삭제하면 피벗 테이블에서 해당 태그가 언급된 컬럼이 모두 삭제 됩니다.
     */
    public function testDeletingATagWillDeleteAllColumnsFromThePivotTableThatAreMentionedForThatTag() : void
    {
        $this->attachTagFromDevelopments();

        $this->assertEquals(3, DevelopmentTag::where('tag_id', $this->tag->id)->count());

        $this->tag->delete();

        $this->assertEquals(0, DevelopmentTag::where('tag_id', $this->tag->id)->count());
    }

    /**
     * 태그를 생성하고 개발 모델과 연결 합니다.
     *
     * @param  int  $times
     */
    protected function attachTagFromDevelopments(int $times = 3) : void
    {
        $this->signIn();

        make(Development::class, [], $times)->each(function (Development $development) {
            $this->post(route('developments.store'), $development->toArray() + ['tags' => [$this->tag->id]]);
        });
    }
}
