<?php

namespace App\Http\Controllers;

use App\Http\Requests\{CommentStoreRequest, CommentUpdateRequest};
use App\Models\{Comment, Development, User};
use App\Notifications\YouWereMentioned;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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
     * @param  CommentStoreRequest  $request
     * @param  Development  $development
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CommentStoreRequest $request, Development $development) : JsonResponse
    {
        $this->authorize('create', new Comment);

        $comment = $development->addComment([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        preg_match_all('/\@([^\s\.]+)/', $comment->body, $matches);

        foreach ($matches[1] as $name) {
            if ($user = User::where('name', $name)->first()) {
                $user->notify(new YouWereMentioned($comment));
            }
        }

        return response()->json([
            'message' => trans('comments.store'),
            'comment' => $comment->load('user'),
        ]);
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  CommentUpdateRequest  $request
     * @param  Comment  $comment
     * @return JsonResponse
     */
    public function update(CommentUpdateRequest $request, Comment $comment) : JsonResponse
    {
        $comment->update($request->all());

        return response()->json(['message' => trans('developments.updated')]);
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
