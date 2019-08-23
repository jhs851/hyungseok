<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\{RedirectResponse, Request};

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (User::socialUser($request->input('email'))->exists()) {
            return $this->sendSocialUserResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * 사용자 인증을 받았습니다.
     *
     * @param  Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        flash()->success(__('auth.welcome', ['name' => $user->name]));
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function logout(Request $request) : RedirectResponse
    {
        return User::withoutSyncingToSearch(function () use ($request) {
            $this->guard()->logout();

            $request->session()->invalidate();

            return $this->loggedOut($request) ?: redirect('/');
        });
    }

    /**
     * 사용자가 응용 프로그램에서 로그아웃되었습니다.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    protected function loggedOut(Request $request) : RedirectResponse
    {
        flash()->success(__('auth.logged_out'));

        return redirect($this->redirectPath());
    }

    /**
     * 소셜 사용자가 네이티비 로그인 시도를 했을 때의 응답입니다.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    protected function sendSocialUserResponse(Request $request): RedirectResponse
    {
        flash()->error(trans('auth.social.is_social'));

        return back()->onlyInput($this->username());
    }
}
