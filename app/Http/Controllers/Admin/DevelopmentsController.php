<?php

namespace App\Http\Controllers\Admin;

use App\Services\DevelopmentsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DevelopmentsController extends Controller
{
    use DevelopmentsService;

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
     * 리소르를 저장한 후에 응답입니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return RedirectResponse
     */
    public function stored(DevelopmentRequest $request, Development $development) : RedirectResponse
    {
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
     * 리소르를 업데이트 한 후에 응답입니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return RedirectResponse
     */
    public function updated(DevelopmentRequest $request, Development $development) : RedirectResponse
    {
        flash()->success(trans('developments.updated'));

        return redirect(route('admin.developments.show', $development->id));
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
        return redirect(route('admin.developments.index'));
    }
}
