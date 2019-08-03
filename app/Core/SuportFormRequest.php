<?php

namespace App\Core;

trait SupportFormRequest
{
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
     * 요청 메서드가 POST인지 확인합니다.
     *
     * @return bool
     */
    protected function isCreate() : bool
    {
        return $this->method() === 'POST';
    }
}
