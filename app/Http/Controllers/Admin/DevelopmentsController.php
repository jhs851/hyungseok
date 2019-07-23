<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DevelopmentsController extends Controller
{
    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        $developmentsCount = Development::count();
        $monthliesCount = Development::monthlies()->count();
        $incremental = parseFloat($monthliesCount / $developmentsCount * 100);
        $countsByDays = Development::withoutAll()->countsByDays()->get();
        $mostVisited = Development::withoutAll()->orderBy('visits', 'desc')->first();

        return view('admin.developments.index', compact('developmentsCount', 'monthliesCount', 'incremental', 'countsByDays', 'mostVisited'));
    }

    /**
     * 새 리소스를 생성하기 위한 폼을 표시합니다.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.developments.create', ['development' => new Development]);
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

        return redirect(route('admin.developments.show', $development->id));
    }

    /**
     * 지정된 리소스를 표시합니다.
     *
     * @param  Development  $development
     * @return View
     */
    public function show(Development $development) : View
    {
        return view('admin.developments.show', compact('development'));
    }

    /**
     * 리소스를 변경하기 위한 폼을 표시합니다.
     *
     * @param  Development  $development
     * @return View
     */
    public function edit(Development $development) : View
    {
        return view('admin.developments.edit', compact('development'));
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return RedirectResponse
     */
    public function update(DevelopmentRequest $request, Development $development) : RedirectResponse
    {
        $development->update($request->all());

        $development->tags()->sync($request->input('tags'));

        flash()->success(trans('developments.updated'));

        return redirect(route('admin.developments.show', $development->id));
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

        return redirect(route('admin.developments.index'));
    }
}
