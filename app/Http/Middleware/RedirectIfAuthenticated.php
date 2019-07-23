<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\{Facades\Auth, Str};

class RedirectIfAuthenticated
{
    /**
     * 들어오는 요청을 처리합니다.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            flash()->warning(__('auth.already_logined'));

            return $this->isAdmin($request)
                ? redirect(route('admin.dashboard'))
                : redirect(route('home'));
        }

        return $next($request);
    }

    /**
     * 현재 로그인한 사용자가 관리자이고 관리자 로그인 페이지에 액세스 했는지 확인합니다.
     *
     * @param  Request  $request
     * @return bool
     */
    protected function isAdmin(Request $request) : bool
    {
        return Str::contains($request->path(), 'admin') && $request->user()->isAdmin;
    }
}
