<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Filters
{
    /**
     * Request 인스턴스.
     *
     * @var Request
     */
    protected $request;

    /**
     * Eloquent Builder 인스턴스.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * 필터링할 메서드 모음들.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Filters 생성자입니다.
     *
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 주어진 Builder를 필터링 합니다.
     *
     * @param  Builder  $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if ($this->hasFilter($filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * 필터링할 메서드들을 반환합니다.
     *
     * @return array
     */
    protected function getFilters() : array
    {
        return $this->request->only($this->filters);
    }

    /**
     * 주어진 filter의 메서드가 있는지 확인합니다.
     *
     * @param  string  $filter
     * @return bool
     */
    protected function hasFilter(string $filter) : bool
    {
        return method_exists($this, $filter) && $this->request->filled($filter);
    }
}
