<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\{RedirectResponse, Request};

class EnsureEmailIsVerified
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
            if ($this->hasNotVerifiedEmail($request)) {
                return $request->expectsJson()
                    ? abort(403, trans('auth.verify.ensure'))
                    : $this->redirectTo($redirectToRoute);
            }

            return $next($request);
        });
    }

    /**
     * 현재 사용자가 이메일 인증이 되었는지 확인합니다.
     *
     * @param  Request  $request
     * @return bool
     */
    protected function hasNotVerifiedEmail(Request $request) : bool
    {
        return $request->user() instanceof MustVerifyEmail && ! $request->user()->hasVerifiedEmail();
    }

    /**
     * Http 요청에 대한 응답입니다.
     *
     * @param  string|null  $redirectToRoute
     * @return RedirectResponse
     */
    protected function redirectTo(string $redirectToRoute = null)
    {
        flash()->error(trans('auth.verify.ensure'));

        return redirect(route($redirectToRoute ?: 'verification.notice'));
    }
}
