<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\{Comment, Development};
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

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
    public function store(CommentRequest $request, Development $development)
    {
        $development->addComment([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        flash()->success(trans('comments.store'));

        return redirect(route('developments.show', $development->id));
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Development  $development
     * @param  Comment  $comment
     * @throws AuthorizationException
     * @return RedirectResponse
     */
    public function destroy(Development $development, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        flash()->success(trans('developments.deleted'));

        return redirect(route('developments.show', $development->id));
    }
}
