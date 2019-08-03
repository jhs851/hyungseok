<?php

use App\Models\Development;
use Illuminate\Database\Seeder;

class DevelopmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Development::class, 10)->create()->each(function ($development) {
            $development->activities()->create([
                'type' => 'created_development',
                'user_id' => $development->user->id,
            ]);
        });

        $this->command->info('Seeded developments table.');
    }
}
