<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\{Comment, Development};
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\{JsonResponse, RedirectResponse};

class CommentsController extends Controller
{
    /**
     * CommentsController 생성자 입니다.
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  CommentRequest  $request
     * @param  Development  $development
     * @return RedirectResponse
     */
    public function store(CommentRequest $request, Development $development) : RedirectResponse
    {
        $development->addComment([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        flash()->success(trans('comments.store'));

        return redirect(route('developments.show', $development->id));
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  CommentRequest  $request
     * @param  Comment  $comment
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(CommentRequest $request, Comment $comment) : JsonResponse
    {
        $this->authorize('update', $comment);

        $comment->update($request->all());

        return response()->json(['message' => trans('developments.updated')]);
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Comment  $comment
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Comment $comment) : JsonResponse
    {
        $this->authorize('update', $comment);

        $comment->delete();

        return response()->json(['message' => trans('developments.deleted')]);
    }
}
