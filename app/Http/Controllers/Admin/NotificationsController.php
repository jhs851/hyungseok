<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        return view('admin.notifications.index', [
            'notificationsCount' => DatabaseNotification::count(),
            'readNotifications' => DatabaseNotification::whereNotNull('read_at')->latest()->paginate(10),
            'unreadNotifications' => DatabaseNotification::whereNull('read_at')->latest()->paginate(10),
        ]);
    }

    /**
     * 읽지 않은 알림을 읽음으로 표시합니다.
     *
     * @param  DatabaseNotification  $notification
     * @return RedirectResponse
     */
    public function mark(DatabaseNotification $notification) : RedirectResponse
    {
        $notification->markAsRead();

        flash()->success(trans('admin.notifications.marked'));

        return redirect(route('admin.notifications.index'));
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  DatabaseNotification  $notification
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(DatabaseNotification $notification) : RedirectResponse
    {
        $notification->delete();

        flash()->success(trans('developments.deleted'));

        return redirect(route('admin.notifications.index'));
    }
}
