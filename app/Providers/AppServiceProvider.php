<?php

namespace App\Providers;

use Illuminate\Support\{Carbon, Facades\Crypt, ServiceProvider};

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
        if ($locale = request()->cookie('locale')) {
            app()->setLocale(Crypt::decrypt($locale, false));

            Carbon::setLocale(app()->getLocale());
        }
    }
}
