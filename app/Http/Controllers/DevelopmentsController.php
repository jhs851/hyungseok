<?php

namespace App\Http\Controllers;

use App\Core\{DevelopmentsService, Trending};
use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\View\View;

class DevelopmentsController extends Controller
{
    use DevelopmentsService;

    /**
     * DevelopmentsController 생성자입니다.
     */
    public function __construct()
    {
        $this->middleware('verified')->except(['index', 'show']);

        $this->middleware('can:update,development')->only(['update', 'destroy']);
    }

    /**
     * 리소스 목록을 표시합니다.
     *
     * @param  Trending  $trending
     * @return LengthAwarePaginator|View
     */
    public function index(Trending $trending)
    {
        return view('developments.index', [
            'trending' => $trending->get(),
        ]);
    }

    /**
     * 새 리소스를 생성하기 위한 폼을 표시합니다.
     *
     * @return View
     */
    public function create() : View
    {
        return view('developments.create', ['development' => new Development]);
    }

    /**
     * 리소르를 저장한 후에 응답입니다.
     *
     * @param  DevelopmentRequest  $request
     * @return RedirectResponse
     */
    public function stored(DevelopmentRequest $request, Development $development) : RedirectResponse
    {
        return redirect(route('developments.show', ['development' => $development->id]));
    }

    /**
     * 지정된 리소스를 표시합니다.
     *
     * @param  Development  $development
     * @param  Trending  $trending
     * @return View
     */
    public function show(Development $development, Trending $trending) : View
    {
        $trending->push($development);

        $development->visits++;
        $development->save();

        return view('developments.show', compact('development'));
    }

    /**
     * 리소르를 업데이트 한 후에 응답입니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return JsonResponse
     */
    public function updated(DevelopmentRequest $request, Development $development) : JsonResponse
    {
        return response()->json([
            'message' => trans('developments.updated'),
            'development' => $development->fresh(),
        ]);
    }

    /**
     * 리소스를 제거 한 후에 응답입니다.
     *
     * @param  Development  $development
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroyed(Development $development) : RedirectResponse
    {
        return redirect(route('developments.index'));
    }
}
