<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Gate;

class CommentRequest extends FormRequest
{
    /**
     * 사용자에게 이 요청을 할 수 있는 권한이 있는지 확인합니다.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        if ($this->isCreate()) {
            return Gate::allows('create', new Comment);
        } elseif ($this->isUpdate()) {
            return Gate::allows('update', $this->route()->comment);
        }

        return false;
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
     * 속성들을 반환합니다.
     *
     * @return array
     */
    public function getAttributes() : array
    {
        return [
            'user_id' => auth()->id(),
            'body' => $this->input('body'),
        ];
    }

    /**
     * 요청 메서드가 POST인지 확인합니다.
     *
     * @return bool
     */
    protected function isCreate() : bool
    {
        return $this->method() === 'POST';
    }

    /**
     * 요청 메서드가 PUT, PETCh인지 확인합니다.
     *
     * @return bool
     */
    protected function isUpdate() : bool
    {
        return in_array($this->method(), ['PUT', 'PETCH']);
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     * @throws AuthorizationException
     */
    protected function failedAuthorization() : void
    {
        if ($this->isCreate()) {
            throw new ThrottleRequestsException(trans('comments.too_many_requests'));
        }

        parent::failedAuthorization();
    }
}
