<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

            return $this->accessingAdmin($request)
                ? route('admin.login')
                : route('login');
        }
    }

    /**
     * 현재 로그인한 사용자가 관리자이고 관리자 로그인 페이지에 액세스 했는지 확인합니다.
     *
     * @param  Request  $request
     * @return bool
     */
    protected function accessingAdmin(Request $request) : bool
    {
        return Str::contains($request->path(), 'admin');
    }
}
