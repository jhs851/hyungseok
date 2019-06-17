<?php

namespace App\Providers;

use Illuminate\Support\{Facades\View, ServiceProvider};

class ViewServiceProvider extends ServiceProvider
{
    /**
     * 컨테이너에 바인딩을 등록합니다.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'auth.*',
            'developments.index',
        ], function ($view) {
            $view->with(['withoutDoorkeeper' => true]);
        });
    }

    /**
     * 서비스 공급자를 등록합니다.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
