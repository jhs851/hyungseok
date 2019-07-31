<?php

namespace App\Console\Commands;

use App\Core\Trending;
use App\Models\{Comment, Development};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Artisan, File, Redis};
use SplFileInfo;

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
        Artisan::call('migrate:refresh', [
            '--force' => true,
            '--seed' => true,
        ]);

        Artisan::call('cache:clear');

        Redis::del((new Trending)->cacheKey());

        collect(File::files(public_path('avatars')))
            ->filter(function (SplFileInfo $file) {
                return ! in_array($file->getFilename(), ['default.png', '.gitignore']);
            })
            ->each(function (SplFileInfo $file) {
                File::delete($file->getPathname());
            });

        Artisan::call('scout:flush', [
            'model' => Development::class,
        ]);

        Artisan::call('scout:import', [
            'model' => Development::class,
        ]);

        Artisan::call('scout:flush', [
            'model' => Comment::class,
        ]);

        Artisan::call('scout:import', [
            'model' => Comment::class,
        ]);

        $this->info('Refreshed.');
    }
}
