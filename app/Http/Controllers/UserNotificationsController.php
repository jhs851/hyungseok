<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserNotificationsController extends Controller
{
    /**
     * UserNotificationsController 생성자 입니다.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 읽지 않은 알림들을 반환합니다.
     *
     * @param  User  $user
     * @return Collection
     */
    public function index(User $user) : Collection
    {
        return $user->unreadNotifications;
    }

    /**
     * 주어진 notification id 값에 해당하는 알림을 읽음으로 표시합니다.
     *
     * @param  User  $user
     * @param  string  $notification
     */
    public function destroy(User $user, string $notification) : void
    {
        $user->notifications()->findOrFail($notification)->markAsRead();
    }
}
