<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\{JsonResponse, Request};

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

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
     * 암호 재설정 링크에 대한 JSON 응답을 반환합니다.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            'status' => trans($response),
        ]);
    }

    /**
     * 실패한 암호 재설정 링크에 대한 JSON 응답을 반환합니다.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json([
            'email' => trans($response),
        ], 404);
    }
}
