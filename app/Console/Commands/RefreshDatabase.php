<?php

namespace App\Console\Commands;

use App\Core\Trending;
use App\Models\{Comment, Development, Tag, User};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Artisan, Redis};

class RefreshDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh and seed the database. Also deletes the cache.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Migration refreshing with seeding...');

        Artisan::call('migrate:refresh', [
            '--force' => true,
            '--seed' => true,
        ]);

        $this->comment('Cache clearing...');

        Artisan::call('cache:clear');

        $this->comment('Redis clearing...');

        Redis::del((new Trending)->cacheKey());

        $this->comment('Scout refresh...');

        $this->refreshScout([
            Development::class, Comment::class, Tag::class, User::class,
        ]);

        $this->info('Refreshed.');
    }

    /**
     * Scout 에 등록된 모델들을 새로고침 합니다.
     *
     * @param  array  $models
     */
    protected function refreshScout(array $models = []) : void
    {
        foreach ($models as $model) {
            Artisan::call('scout:flush', compact('model'));

            Artisan::call('scout:import', compact('model'));
        }
    }
}
