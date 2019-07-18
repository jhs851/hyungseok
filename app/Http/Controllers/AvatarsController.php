<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvatarRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AvatarsController extends Controller
{
    /**
     * AvatarsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:update,user']);
    }

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

    /**
     * 주어진 사용자의 아바타를 삭제합니다.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function destroy(User $user) : JsonResponse
    {
        if ($avatar = $user->avatar_path) {
            $user->update(['avatar_path' => null]);

            Storage::delete($avatar);
        }

        return response()->json([
            'message' => trans('auth.avatars.removed'),
        ]);
    }
}
