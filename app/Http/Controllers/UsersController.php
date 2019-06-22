<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $developments = $user->developments()->paginate(30);

        return view('users.show', compact('user', 'developments'));
    }
}
