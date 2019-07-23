<?php

namespace App\Http\Controllers;

use App\Core\Trending;
use App\Filters\DevelopmentFilters;
use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\{JsonResponse, RedirectResponse};
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
     * @param  Trending  $trending
     * @return LengthAwarePaginator|View
     */
    public function index(DevelopmentFilters $filters, Trending $trending)
    {
        // $developments = $this->getDevelopments($filters);

//        if (request()->expectsJson()) {
//            return $developments;
//        }

        return view('developments.index', [
            // 'developments' => $developments,
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
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  DevelopmentRequest  $request
     * @return RedirectResponse
     */
    public function store(DevelopmentRequest $request) : RedirectResponse
    {
        $development = $request->user()->developments()->create($request->all());

        $development->tags()->sync($request->input('tags'));

        flash()->success(trans('developments.store'));

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
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return JsonResponse
     */
    public function update(DevelopmentRequest $request, Development $development) : JsonResponse
    {
        $development->update($request->all());

        $development->tags()->sync($request->input('tags'));

        return response()->json([
            'message' => trans('developments.updated'),
            'development' => $development->fresh(),
        ]);
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
        return Development::filter($filters)->orderBy('created_at', 'desc')->paginate(10);
    }
}
