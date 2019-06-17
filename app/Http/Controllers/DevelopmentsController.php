<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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
    }

    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        $query = new Development;

        if ($username = request('by')) {
            $user = User::where('name', $username)->firstOrFail();

            $query = $query->where('user_id', $user->id);
        }

        $developments = $query->latest()->paginate(10);

        return view('developments.index', compact('developments'));
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
        return view('developments.show', compact('development'));
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(DevelopmentRequest $request, Development $development) : JsonResponse
    {
        $this->authorize('update', $development);

        $development->update($request->all());

        return response()->json([
            'message' => trans('developments.updated'),
            'development' => $development,
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
        $this->authorize('update', $development);

        $development->delete();

        flash()->success(trans('developments.deleted'));

        return redirect(route('developments.index'));
    }
}
