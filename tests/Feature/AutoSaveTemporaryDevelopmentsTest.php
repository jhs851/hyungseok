<?php

namespace Tests\Feature;

use App\Models\{Tag, TemporaryDevelopment, User};
use Illuminate\Contracts\Container\BindingResolutionException as BindingResolutionExceptionAlias;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AutoSaveTemporaryDevelopmentsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * TemporaryDevelopment 인스턴스.
     *
     * @var TemporaryDevelopment
     */
    protected $temporaryDevelopment;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws BindingResolutionExceptionAlias
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->temporaryDevelopment = create(TemporaryDevelopment::class);
    }

    /**
     * 게스트는 임시 개발글을 작성하거나 변경, 삭제 할 수 없습니다.
     */
    public function testGuestsCannotCreateOrUpdateOrDeleteTemporaryDevelopments(): void
    {
        $this->withExceptionHandling();

        $this->post(route('temporary-developments.store'))
             ->assertRedirect(route('login'));

        $this->put(route('temporary-developments.update', $this->temporaryDevelopment->id))
             ->assertRedirect(route('login'));

        $this->delete(route('temporary-developments.destroy', $this->temporaryDevelopment->id))
             ->assertRedirect(route('login'));
    }

    /**
     * 이메일을 인증하지 않은 사용자는 임시 개발글을 작성하거나 변경, 삭제 할 수 없습니다.
     */
    public function testUnconfirmedUsersCannotCreateOrUpdateDeleteTemporaryDevelopments(): void
    {
        $this->signIn(factory(User::class)->state('unconfirmed')->create());

        $this->post(route('temporary-developments.store'))
            ->assertRedirect(route('verification.notice'));

        $this->put(route('temporary-developments.update', $this->temporaryDevelopment->id))
            ->assertRedirect(route('verification.notice'));

        $this->delete(route('temporary-developments.destroy', $this->temporaryDevelopment->id))
            ->assertRedirect(route('verification.notice'));
    }

    /**
     * 임시 개발글을 제목값이 필수 항목입니다.
     */
    public function testTemporaryDevelopmentTitleIsRequires(): void
    {
        $this->signIn()
             ->withExceptionHandling()
             ->post(route('temporary-developments.store'), ['title' => ''])
             ->assertSessionHasErrors('title');
    }

    /**
     * 임시 개발글은 본문값이 필수 항목입니다.
     */
    public function testTemporaryDevelopmentBodyIsRequires(): void
    {
        $this->signIn()
            ->withExceptionHandling()
            ->post(route('temporary-developments.store'), ['title' => 'Foobar', 'body' => ''])
            ->assertSessionHasErrors('body');
    }

    /**
     * 사용자는 임시 개발글을 작성할 수 있습니다.
     */
    public function testUsersCanCreateATemporaryDevelopments(): void
    {
        $this->signIn();

        $data = ['title' => 'Hello', 'body' => 'There'];

        $this->post(route('temporary-developments.store'), $data);

        $this->assertDatabaseHas('temporary_developments', $data);
    }

    /**
     * 사용자는 권한이 없는 임시 개발글을 변경하거나 삭제할 수 없습니다.
     */
    public function testUnauthorizeUsersCannotUpdateAndDeleteTemporaryDevelopments(): void
    {
        $this->withExceptionHandling()
             ->signIn();

        $this->put(route('temporary-developments.update', $this->temporaryDevelopment->id))
             ->assertStatus(403);

        $this->delete(route('temporary-developments.destroy', $this->temporaryDevelopment->id))
             ->assertStatus(403);
    }

    /**
     * 사용자는 자신의 임시 개발글을 변경할 수 있습니다.
     */
    public function testUsersCanUpdateTemporaryDevelopments(): void
    {
        $this->signIn(User::find($this->temporaryDevelopment->user_id))
             ->put(route('temporary-developments.update', $this->temporaryDevelopment->id), [
                 'title' => 'Updated',
                 'body' => 'Updated Body',
             ]);

        tap($this->temporaryDevelopment->fresh(), function ($temporaryDevelopment) {
            $this->assertEquals('Updated', $temporaryDevelopment->title);
            $this->assertEquals('Updated Body', $temporaryDevelopment->body);
        });
    }

    /**
     * 사용자는 임시 개발글을 삭제할 수 있습니다.
     */
    public function testUsersCanDeleteTemporaryDevelopments(): void
    {
        $this->signIn(User::find($this->temporaryDevelopment->user_id))
             ->delete(route('temporary-developments.destroy', $this->temporaryDevelopment->id));

        $this->assertDatabaseMissing('temporary_developments', ['id' => $this->temporaryDevelopment->id]);
    }

    /**
     * 사용자는 자신의 임시 개발글이 있다면 볼 수 있습니다.
     */
    public function testUsersCanViewTheirTemporaryDevelopmentIfTheyHaveOne(): void
    {
        $this->signIn();

        create(TemporaryDevelopment::class, ['user_id' => auth()->id()]);

        $response = $this->get(route('temporary-developments.index', ['action' => 'create']))->json();

        $this->assertCount(1, $response);
    }

    /**
     * 개발 글을 작성완료 했을 때 저장돼있던 임시 개발글은 삭제됩니다.
     */
    public function testWhenCompleteTheDevelopmentTheTemporaryDevelopmentThatWasSavedWillBeDelete(): void
    {
        $this->signIn(User::find($this->temporaryDevelopment->user_id))
             ->post(route('developments.store', [
                 'title' => 'Foo',
                 'body' => 'Bar',
                 'tags' => [create(Tag::class)->id],
             ]));

        $this->assertEquals(null, $this->temporaryDevelopment->fresh());
    }
}
