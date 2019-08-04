<?php

namespace App\Http\Controllers\Admin;

use App\Events\TagCreated;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Exception;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TagsController extends Controller
{
    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        return view('admin.tags.index', [
            'tagsCount' => Tag::count(),
            'mostMentionedTag' => Tag::orderBy('mentions', 'desc')->first(),
            'unmentionedTags' => Tag::where('mentions', 0)->get(),
        ]);
    }

    /**
     * 새 리소스를 생성하기 위한 폼을 표시합니다.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.tags.create', ['tag' => new Tag]);
    }

    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  TagRequest  $request
     * @return RedirectResponse
     */
    public function store(TagRequest $request) : RedirectResponse
    {
        TagCreated::dispatch(Tag::create($request->all()));

        flash()->success(trans('developments.store'));

        return redirect(route('admin.tags.index'));
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  TagRequest  $request
     * @param  Tag  $tag
     * @return JsonResponse
     */
    public function update(TagRequest $request, Tag $tag) : JsonResponse
    {
        $tag->update($request->all());

        return response()->json([
            'message' => trans('developments.updated'),
        ]);
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Tag  $tag
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Tag $tag) : JsonResponse
    {
        $tag->delete();

        return response()->json([
            'message' => trans('developments.deleted'),
        ]);
    }
}
