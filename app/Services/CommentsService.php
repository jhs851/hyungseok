<?php

namespace App\Services;

use App\Http\Requests\CommentRequest;
use App\Models\{Comment, Development};
use Exception;
use Illuminate\Foundation\Auth\RedirectsUsers;

trait CommentsService
{
    use RedirectsUsers;

    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  CommentRequest  $request
     * @param  Development  $development
     * @return mixed
     */
    public function store(CommentRequest $request, Development $development)
    {
        $comment = $development->addComment($request->getAttributes())->load('user');

        return $this->stored($request, $development, $comment) ?:
            redirect($this->redirectPath());
    }

    /**
     * 리소스를 저장한 후에 응답입니다.
     *
     * @param  CommentRequest  $request
     * @param  Development  $development
     * @param  Comment  $comment
     * @return mixed
     */
    public function stored(CommentRequest $request, Development $development, Comment $comment)
    {
        //
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  CommentRequest  $request
     * @param  Comment  $comment
     * @return mixed
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->getAttributes());

        return $this->updated($request, $comment) ?:
            redirect($this->redirectPath());
    }

    /**
     * 리소스를 업데이트 한 후에 응답입니다.
     *
     * @param  CommentRequest  $request
     * @param  Comment  $comment
     * @return mixed
     */
    public function updated(CommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Comment  $comment
     * @return mixed
     * @throws Exception
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        return $this->destroyed($comment) ?:
            redirect($this->redirectPath());
    }

    /**
     * 리소스를 제거 한 후에 응답입니다.
     *
     * @param  Comment  $comment
     * @return mixed
     */
    public function destroyed(Comment $comment)
    {
        //
    }
}
