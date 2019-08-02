<?php

namespace App\Http\Controllers\Admin;

use App\Models\Favorite;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoritesController extends Controller
{
    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        $mostFavorited = Favorite::countByFavorited()->orderBy('favorites_count', 'desc')->first();

        return view('admin.favorites.index', [
            'favorites' => Favorite::latest()->paginate(10),
            'mostFavorited' => $mostFavorited ? $mostFavorited->favorited : null,
        ]);
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Favorite  $favorite
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Favorite $favorite) : RedirectResponse
    {
        $favorite->delete();

        flash()->success(trans('developments.deleted'));

        return redirect(route('admin.favorites.index'));
    }
}
