<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FunctionsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * parseFloat 함수는 주어진 값을 주어진 자릿수로 파싱합니다.
     */
    public function testParseFloatFunctionIsParsesAGivenValueToAGivenNumberOfDigits() : void
    {
        $this->assertEquals('1', parseFloat(1));

        $this->assertEquals('1.23', parseFloat(1.23456));

        $this->assertEquals('1.23456', parseFloat(1.23456, 5));
    }
}
