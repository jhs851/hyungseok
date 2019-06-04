<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\{RedirectResponse, Request};

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 암호 재설정에 성공한 응답을 가져옵니다.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return RedirectResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        flash()->success(trans($response));

        return redirect($this->redirectPath());
    }
}
