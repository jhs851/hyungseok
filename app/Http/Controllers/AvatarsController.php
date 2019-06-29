<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvatarRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AvatarsController extends Controller
{
    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  AvatarRequest  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function store(AvatarRequest $request, User $user) : JsonResponse
    {
        $user->update($request->getAttributes());

        return response()->json([
            'message' => trans('auth.avatars.store'),
            'avatar' => $user->avatar,
        ]);
    }
}
