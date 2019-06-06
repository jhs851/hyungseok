<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DevelopmentRequest extends FormRequest
{
    /**
     * 사용자에게 이 요청을 할 수 있는 권한이 있는지 확인합니다.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * 요청에 적용되는 유효성 검사 규칙을 반환합니다.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
        ];
    }
}