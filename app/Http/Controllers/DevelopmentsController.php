<?php

namespace App\Http\Controllers;

use App\Filters\DevelopmentFilters;
use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;
use Exception;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class DevelopmentsController extends Controller
{
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
     * @param  DevelopmentFilters  $filters
     * @return LengthAwarePaginator|View
     */
    public function index(DevelopmentFilters $filters)
    {
        $developments = $this->getDevelopments($filters);

        if (request()->expectsJson()) {
            return $developments;
        }

        $trending = array_map('json_decode', Redis::zrevrange('trending_developments', 0, 4));

        return view('developments.index', compact('developments', 'trending'));
    }

    /**
     * 새 리소스를 생성하기 위한 폼을 표시합니다.
     *
     * @return View
     */
    public function create() : View
    {
        return view('developments.create');
    }

    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  DevelopmentRequest  $request
     * @return RedirectResponse
     */
    public function store(DevelopmentRequest $request) : RedirectResponse
    {
        $development = $request->user()->developments()->create($request->all());

        flash()->success(trans('developments.store'));

        return redirect(route('developments.show', ['development' => $development->id]));
    }

    /**
     * 지정된 리소스를 표시합니다.
     *
     * @param  Development  $development
     * @return View
     */
    public function show(Development $development) : View
    {
        Redis::zincrby('trending_developments', 1, json_encode([
            'title' => $development->title,
            'path' => route('developments.show', $development->id),
        ]));

        return view('developments.show', compact('development'));
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return JsonResponse
     */
    public function update(DevelopmentRequest $request, Development $development) : JsonResponse
    {
        $development->update($request->all());

        return response()->json(['message' => trans('developments.updated')]);
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Development  $development
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Development $development) : RedirectResponse
    {
        $development->delete();

        flash()->success(trans('developments.deleted'));

        return redirect(route('developments.index'));
    }

    /**
     * 개발 포스트를 반환합니다.
     *
     * @param  DevelopmentFilters  $filters
     * @return LengthAwarePaginator
     */
    protected function getDevelopments(DevelopmentFilters $filters) : LengthAwarePaginator
    {
        return Development::filter($filters)->latest()->paginate(10);
    }
}
