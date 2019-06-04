<?php

namespace App\Http\Controllers;

use KgBot\LaravelLocalization\Classes\ExportLocalizations;

class LanguagesController extends Controller
{
    public function __invoke(ExportLocalizations $localizations)
    {
        $languages = $localizations->export()->toArray();

        return array_merge(
            $languages[$this->locale()],
            $this->getJsonLocale($languages)
        );
    }

    /**
     * 현재 응용프로그램의 locale을 가져옵니다.
     *
     * @return string
     */
    protected function locale() : string
    {
        return app()->getLocale();
    }

    /**
     * 현재 응용프로그램의 locale json 값을 배열로 반환합니다.
     *
     * @param  array  $languages
     * @return array
     */
    protected function getJsonLocale(array $languages) : array
    {
        if ($this->hasJsonLocale($languages)) {
            return (array) $languages['json'][$this->locale()];
        }

        return [];
    }

    /**
     * 현재 응용프로그램의 locale json 값이 있는지 확인합니다.
     *
     * @param  array  $languages
     * @return bool
     */
    protected function hasJsonLocale(array $languages) : bool
    {
        return array_key_exists('json', $languages) &&
               array_key_exists($this->locale(), $languages['json']);
    }
}
