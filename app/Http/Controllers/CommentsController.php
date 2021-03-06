<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentsService;
use App\Models\{Comment, Development};
use Illuminate\Http\JsonResponse;

class CommentsController extends Controller
{
    use CommentsService;

    /**
     * CommentsController 생성자 입니다.
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * 리소스를 저장한 후에 응답입니다.
     *
     * @param  CommentRequest  $request
     * @param  Development  $development
     * @param  Comment  $comment
     * @return JsonResponse
     */
    public function stored(CommentRequest $request, Development $development, Comment $comment) : JsonResponse
    {
        return response()->json([
            'message' => trans('comments.store'),
            'comment' => $comment,
        ]);
    }

    /**
     * 리소스를 업데이트 한 후에 응답입니다.
     *
     * @param  CommentRequest  $request
     * @param  Comment  $comment
     * @return JsonResponse
     */
    public function updated(CommentRequest $request, Comment $comment) : JsonResponse
    {
        return response()->json([
            'message' => trans('developments.updated'),
            'comment' => $comment,
        ]);
    }

    /**
     * 리소스를 제거 한 후에 응답입니다.
     *
     * @param  Comment  $comment
     * @return JsonResponse
     */
    public function destroyed(Comment $comment) : JsonResponse
    {
        return response()->json(['message' => trans('developments.deleted')]);
    }
}
