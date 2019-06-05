<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * 인증되지 않은 경우 사용자가 리디렉션해야 하는 경로를 반환합니다.
     *
     * @param  Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            flash()->error(trans('auth.unauthenticated'));

            return route('login');
        }
    }
}
