<?php

namespace Tests;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Http\Request;

class TestHandler extends Handler
{
    /**
     * TestHandler constructor.
     */
    public function __construct()
    {
    }

    /**
     * 예외를 보고하거나 기록합니다.
     *
     * @param  Exception  $e
     */
    public function report(Exception $e)
    {
    }

    /**
     * Test 환경에서는 렌더링 하지 않고 예외 그대로 던집니다.
     *
     * @param  Request  $request
     * @param  Exception  $e
     * @throws Exception
     */
    public function render($request, Exception $e)
    {
        throw $e;
    }
}
