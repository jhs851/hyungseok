<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\{RedirectResponse, Request, Response};

class VerificationController extends Controller
{
    use RedirectsUsers;

    /**
     * VerificationController 생성자입니다.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * 이메일 인증 폼을 표시합니다.
     *
     * @param  Request  $request
     * @return RedirectResponse|Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? $this->alreadyVerified()
            : view('auth.verify');
    }

    /**
     * 사용자의 이메일 주소를 인증한 것으로 표시합니다.
     *
     * @param  Request  $request
     * @return RedirectResponse|Response
     * @throws AuthorizationException
     */
    public function verify(Request $request)
    {
        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $this->alreadyVerified();
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->verified($request)
            ?: redirect($this->redirectPath());
    }

    /**
     * 이메일 확인 알림을 다시 전송 합니다.
     *
     * @param  Request  $request
     * @return RedirectResponse|Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->alreadyVerified();
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    /**
     * 이미 이메일 인증이된 사용자에 대한 응답입니다.
     *
     * @return RedirectResponse
     */
    protected function alreadyVerified()
    {
        flash()->warning(trans('auth.verify.already'));

        return redirect($this->redirectPath());
    }

    /**
     * 사용자의 이메일 주소를 인증한 뒤에 반환할 내용입니다.
     *
     * @param  Request  $request
     * @return mixed
     */
    protected function verified(Request $request)
    {
        flash()->success(trans('auth.verify.verified'));
    }
}
