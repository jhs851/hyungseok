<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => config('auth.admin.name'),
            'email' => config('auth.admin.email')[0],
        ]);

        $this->command->info('Users table seeded.');
    }
}
