<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * @param  Request  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function store(Request $request, User $user) : RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image'],
        ]);

        $user->update([
            'avatar_path' => $request->file('avatar')->store('avatars', 'public'),
        ]);

        flash()->success(trans('auth.avatars.store'));

        return redirect(route('users.show', $user->id));
    }
}
