<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
     * 사용자가 응용 프로그램에서 로그아웃되었습니다.
     *
     * @param  Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        flash()->success(__('auth.logged_out'));

        return redirect($this->redirectPath());
    }
}
