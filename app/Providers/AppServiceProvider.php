<?php

namespace App\Providers;

use Illuminate\Support\{Facades\Blade, ServiceProvider};

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
        $this->registerComponents();
    }

    /**
     * 컴포넌트들을 등록합니다.
     */
    protected function registerComponents() : void
    {
        Blade::component('layouts.components.doorkeeper', 'doorkeeper');

        Blade::component('layouts.components.line', 'line');
    }
}
