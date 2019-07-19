<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\{RedirectResponse, Request};

class Administrator
{
    /**
     * 들어오는 요청을 처리합니다.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $redirectToRoute
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $redirectToRoute = null)
    {
        return app(Authenticate::class)->handle($request, function (Request $request) use ($next, $redirectToRoute) {
            if (! $request->user()->isAdmin) {
                return abort(401, trans('admin.unauthorize'));
            }

            return $next($request);
        });
    }
}
