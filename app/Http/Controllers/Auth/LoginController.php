<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
}
