<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Development;
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

        return redirect(route('developments.show', $development->id));
    }
}
