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
        Development::all()->each(function (Development $development) {
            factory(Comment::class, 5)->create(['development_id' => $development->id])->each(function ($comment) {
                $comment->activities()->create([
                    'type' => 'created_comment',
                    'user_id' => $comment->user->id,
                ]);
            });
        });

        $this->command->info('Seeded comments table.');
    }
}
