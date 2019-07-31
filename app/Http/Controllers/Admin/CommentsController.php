<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommentRequest;
use App\Services\CommentsService;
use App\Models\{Comment, Development};
use App\Http\Controllers\Controller;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\View\View;

class CommentsController extends Controller
{
    use CommentsService;

    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        return view('admin.comments.index', [
            'commentsCount' => Comment::count(),
            'mostCommentable' => Development::orderBy('comments_count', 'desc')->first(),
        ]);
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
     * @return JsonResponse|RedirectResponse
     */
    public function destroyed(Comment $comment)
    {
        if (request()->expectsJson()) {
            return response()->json(['message' => trans('developments.deleted')]);
        }

        flash()->success(trans('developments.deleted'));

        return redirect(route('admin.comments.index'));
    }
}
