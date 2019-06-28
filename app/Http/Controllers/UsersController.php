<?php

namespace App\Http\Controllers;

use App\Models\{Activity, User};
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * 주어진 이름으로 사용자들의 이름을 반환합니다.
     *
     * @param  Request  $request
     * @return Collection
     */
    public function index(Request $request) : Collection
    {
        $search = $request->get('name');

        return User::where('name', 'LIKE', "{$search}%")
            ->where('name', '!=', $request->user()->name)
            ->take(5)
            ->get('name');
    }

    /**
     * 지정된 리소스를 표시합니다.
     *
     * @param  User  $user
     * @return View
     */
    public function show(User $user) : View
    {
        $groups = Activity::feed($user);

        return view('users.show', compact('user', 'groups'));
    }
}
