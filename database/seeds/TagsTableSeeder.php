<?php

use App\Models\{Development, Tag};
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Development::all()->each(function (Development $development) {
            $development->tags()->sync(factory(Tag::class, 3)->create()->pluck('id'));
        });

        $this->command->info('Seeded tags table and synced developments.');
    }
}
