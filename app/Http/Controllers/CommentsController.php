<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\{Comment, Development};
use Exception;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function store(CommentRequest $request, Development $development) : JsonResponse
    {
        return response()->json([
            'message' => trans('comments.store'),
            'comment' => $development->addComment($request->getAttributes())->load('user'),
        ]);
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  CommentRequest  $request
     * @param  Comment  $comment
     * @return JsonResponse
     */
    public function update(CommentRequest $request, Comment $comment) : JsonResponse
    {
        $comment->update($request->getAttributes());

        return response()->json([
            'message' => trans('developments.updated'),
            'comment' => $comment,
        ]);
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Comment  $comment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Comment $comment) : JsonResponse
    {
        $this->authorize('update', $comment);

        $comment->delete();

        return response()->json(['message' => trans('developments.deleted')]);
    }
}
