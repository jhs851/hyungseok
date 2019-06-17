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
        factory(Development::class, 50)->create();

        $this->command->info('Seeded developments table.');
    }
}
