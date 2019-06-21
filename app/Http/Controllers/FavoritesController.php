<?php

namespace App\Http\Controllers;

use App\Models\Development;
use Illuminate\Http\RedirectResponse;

class FavoritesController extends Controller
{
    /**
     * FavoritesController 생성자 입니다.
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  Development  $development
     * @return RedirectResponse
     */
    public function store(Development $development) : RedirectResponse
    {
        $development->favorite();

        return redirect(route('developments.show', ['development' => $development->id]));
    }
}
