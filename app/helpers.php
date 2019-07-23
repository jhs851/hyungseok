<?php

if (! function_exists('parseFloat')) {
    /**
     * 주어진 값을 주어진 자릿수로 파싱합니다.
     *
     * @param  int|float  $value
     * @param  int  $digits
     * @return string
     */
    function parseFloat($value, int $digits = 2) : string
    {
        return is_float($value) ? sprintf("%.{$digits}f", $value) : $value;
    }
}
