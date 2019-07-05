<?php

namespace Tests\Feature;

use App\Models\Development;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserCanSearchDevelopments() : void
    {
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';

        create(Development::class, [], 2);

        create(Development::class, ['body' => "A development with the {$search} term."], 2);

        do {
            sleep(.25);

            $response = $this->getJson("/developments/?search={$search}")->json()['data'];
        } while (empty($response));

        $this->assertCount(2, $response);

        Development::latest()->take(4)->unsearchable();
    }
}
