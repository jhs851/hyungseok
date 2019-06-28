<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Gate;

class CommentStoreRequest extends FormRequest
{
    /**
     * 사용자에게 이 요청을 할 수 있는 권한이 있는지 확인합니다.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return Gate::allows('create', new Comment);
    }

    /**
     * 요청에 적용되는 유효성 검사 규칙을 반환합니다.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'body' => 'required',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     */
    protected function failedAuthorization() : void
    {
        throw new ThrottleRequestsException(trans('comments.too_many_requests'));
    }
}
