<?php

use Illuminate\Database\Eloquent\Model;

if (! function_exists('create')) {
    /**
     * 테스트를 위한 더미 모델을 생성합니다.
     *
     * @param  string  $class
     * @param  array  $attributes
     * @param  int|null  $times
     * @return Model
     */
    function create(string $class, array $attributes = [], int $times = null) : Model
    {
        return factory($class, $times)->create($attributes);
    }
}

if (! function_exists('make')) {
    /**
     * 테스트를 위한 더미 모델을 만듭니다.
     *
     * @param  string  $class
     * @param  array  $attributes
     * @param  int|null  $times
     * @return Model
     */
    function make(string $class, array $attributes = [], int $times = null) : Model
    {
        return factory($class, $times)->make($attributes);
    }
}
