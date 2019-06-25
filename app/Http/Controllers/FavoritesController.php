<?php

namespace App\Http\Controllers;

use App\Models\Development;

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
     */
    public function store(Development $development)
    {
        $development->favorite();
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Development  $development
     */
    public function destroy(Development $development)
    {
        $development->unfavorite();
    }
}
