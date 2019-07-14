<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TaggingTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 태그들을 가져올 수 있습니다.
     */
    public function testCanImportTags() : void
    {
        $tags = create(Tag::class, [], 2);

        $response = $this->get(route('api.tags.index'))->json();

        $this->assertCount($tags->count(), $response);
    }
}
