<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Validator};
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * RegisterController의 생성자 입니다.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 들어오는 등록 요청에 대한 Validator를 가져옵니다.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * 유효성 검사 후 새 사용자 인스턴스를 만듭니다.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) : User
    {
        return User::register($data);
    }

    /**
     * 사용자가 등록된 후에 동작입니다.
     *
     * @param  Request  $request
     * @param  mixed  $user
     */
    protected function registered(Request $request, $user) : void
    {
        flash()->success(__('auth.welcome', ['name' => $user->name]));
    }
}
