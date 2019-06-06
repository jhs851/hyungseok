<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DevelopmentsController extends Controller
{
    /**
     * DevelopmentsController 생성자입니다.
     */
    public function __construct()
    {
        $this->middleware('verified')->except(['index', 'show']);
    }

    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        return view('developments.index', ['developments' => Development::latest()->get()]);
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
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 지정된 리소스를 편집하기 위한 폼을 표시합니다.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
