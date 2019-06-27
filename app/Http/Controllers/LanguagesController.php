<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use KgBot\LaravelLocalization\Classes\ExportLocalizations;

class LanguagesController extends Controller
{
    public function __invoke(ExportLocalizations $localizations)
    {
        return response($this->getContent($localizations))
            ->header('Content-type', 'text/javascript');
    }

    /**
     * 응답에 반환할 컨텐츠를 반환합니다.
     *
     * @param  ExportLocalizations  $localizations
     * @return string
     */
    protected function getContent(ExportLocalizations $localizations) : string
    {
        $i18n = 'window.i18n = ' . json_encode(
            $this->getLanguages($localizations->export()->toArray()), JSON_UNESCAPED_UNICODE
        );

        if (app()->environment('production')) {
            return Cache::rememberForever('languages.js', function () use ($i18n) {
                return $i18n;
            });
        }

        return $i18n;
    }

    /**
     * 번역 내용을 반환합니다.
     *
     * @param  array  $languages
     * @return array
     */
    protected function getLanguages(array $languages) : array
    {
        return array_merge(
            $languages[$this->getLocale()],
            $this->getJsonLocale($languages)
        );
    }

    /**
     * 현재 응용프로그램의 locale을 가져옵니다.
     *
     * @return string
     */
    protected function getLocale() : string
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
            return (array) $languages['json'][$this->getLocale()];
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
               array_key_exists($this->getLocale(), $languages['json']);
    }
}
