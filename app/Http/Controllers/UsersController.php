<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * 지정된 리소스를 표시합니다.
     *
     * @param  User  $user
     * @return View
     */
    public function show(User $user) : View
    {
        $groups = $this->getActivities($user);

        return view('users.show', compact('user', 'groups'));
    }

    /**
     * 주어진 사용자의 활동 내역을 일별로 그룹화해서 반환합니다.
     *
     * @param  User  $user
     * @return Collection
     */
    protected function getActivities(User $user) : Collection
    {
        return $user->activities()->with('subject')->latest()->get()->groupBy(function ($activity) {
            return $activity->type;
        });
    }
}
