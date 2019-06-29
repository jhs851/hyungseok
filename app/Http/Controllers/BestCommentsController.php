<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;

class BestCommentsController extends Controller
{
    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  Comment  $comment
     * @throws AuthorizationException
     */
    public function store(Comment $comment)
    {
        $this->authorize('update', $comment->development);

        $comment->development->markBestComment($comment);
    }
}
