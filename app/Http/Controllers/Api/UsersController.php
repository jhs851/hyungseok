<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UsersController extends Controller
{
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
            ->take(5)
            ->get('name');
    }
}
