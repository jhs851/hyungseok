<?php

use App\Models\{Comment, Development};
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Development::all()->each(function ($development) {
            factory(Comment::class, 10)->create(['development_id' => $development->id]);
        });

        $this->command->info('Seeded comments table.');
    }
}
