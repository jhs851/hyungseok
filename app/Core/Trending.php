<?php

namespace App\Core;

use App\Models\Development;
use Illuminate\Support\Facades\Redis;

class Trending
{
    /**
     * 내림차순으로 5개의 유행하는 글을 반환합니다.
     *
     * @return array
     */
    public function get() : array
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 4));
    }

    /**
     * 주어진 개발 포스트의 조회 수를 한개 증가 시킵니다.
     *
     * @param  Development  $development
     */
    public function push(Development $development) : void
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $development->title,
            'path' => route('developments.show', $development->id),
        ]));
    }

    /**
     * 현재 redis에 저장된 개발 포스트 조회 수를 모두 제거합니다.
     *
     * @return static
     */
    public static function reset() : Trending
    {
        Redis::del((new static)->cacheKey());

        return new static;
    }

    /**
     * 캐시 키를 반환합니다.
     *
     * @return string
     */
    protected function cacheKey()
    {
        return app()->environment('testing') ? 'testing_trending_developments' : 'trending_developments';
    }
}
