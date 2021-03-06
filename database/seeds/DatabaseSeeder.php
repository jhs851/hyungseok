<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            $this->call(DevelopmentsTableSeeder::class);

            $this->call(CommentsTableSeeder::class);

            $this->call(TagsTableSeeder::class);

            $this->call(UsersTableSeeder::class);
        }
    }
}
