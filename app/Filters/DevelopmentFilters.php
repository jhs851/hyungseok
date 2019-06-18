<?php

namespace App\Filters;

use App\Models\User;

class DevelopmentFilters extends Filters
{
    /**
     * 필터링할 메서드 모음들.
     *
     * @var array
     */
    protected $filters = [
        'by',
    ];

    /**
     * 주어진 사용자 이름으로 개발 포스트를 필터링 합니다.
     *
     * @param  string  $username
     */
    protected function by(string $username) : void
    {
        $this->builder->where('user_id', User::where('name', $username)->value('id'));
    }
}
