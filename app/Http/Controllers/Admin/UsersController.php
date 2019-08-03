<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        $usersCount = User::count();
        $monthliesCount = User::monthlies()->count();
        $incremental = parseFloat($monthliesCount / $usersCount * 100);
        $countsByDays = User::countsByDays()->get();
        $activeUsersCount = User::whereNotNull('email_verified_at')->count();
        $unactiveUsersCount = User::whereNull('email_verified_at')->count();

        return view('admin.users.index', compact('usersCount', 'monthliesCount', 'incremental', 'countsByDays', 'activeUsersCount', 'unactiveUsersCount'));
    }

    /**
     * 새 리소스를 생성하기 위한 폼을 표시합니다.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.users.create', ['user' => new User]);
    }

    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  UserRequest  $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request) : RedirectResponse
    {
        event(new Registered($user = User::create($request->all())));

        flash()->success(trans('admin.users.store'));

        return redirect(route('admin.users.index'));
    }

    /**
     * 지정된 리소스를 표시합니다.
     *
     * @param  User  $user
     * @return View
     */
    public function show(User $user) : View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * 리소스를 변경하기 위한 폼을 표시합니다.
     *
     * @param  User  $user
     * @return View
     */
    public function edit(User $user) : View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  UserRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user) : RedirectResponse
    {
        $user->update($request->all());

        flash()->success(trans('developments.updated'));

        return redirect(route('admin.users.show', $user->id));
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  User  $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user) : RedirectResponse
    {
        $user->delete();

        flash()->success(trans('developments.deleted'));

        return redirect(route('admin.users.index'));
    }
}
