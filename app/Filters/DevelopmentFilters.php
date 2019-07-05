<?php

namespace App\Filters;

use App\Models\{Development, User};

class DevelopmentFilters extends Filters
{
    /**
     * 필터링할 메서드 모음들.
     *
     * @var array
     */
    protected $filters = [
        'search',
        'by',
        'popularity',
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

    /**
     * 개발 포스트를 댓글 수의 내림차순으로 정렬합니다.
     */
    protected function popularity() : void
    {
        $this->builder->orderBy('comments_count', 'desc');
    }

    /**
     * 검색한 내용이 있으면 검색한 내용으로 필터링 합니다.
     *
     * @param  string  $search
     */
    protected function search(string $search) : void
    {
        $this->builder = Development::search($search);
    }
}
