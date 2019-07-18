<?php

namespace App\Providers;

use App\Models\{Comment, Development};
use App\Observers\{CommentObserver, DevelopmentObserver};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerObservers();
    }

    /**
     * 모델의 옵저버를 등록합니다.
     */
    protected function registerObservers()
    {
        Comment::observe(CommentObserver::class);
        Development::observe(DevelopmentObserver::class);
    }
}
