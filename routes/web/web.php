<?php

// Homepage
Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController',
]);

// Frontend Localization
Route::get('/js/languages.js', [
    'as' => 'assets.lang',
    'uses' => 'LanguagesController@front',
]);

// Backend Localization
Route::get('/locale/{locale}', [
    'as' => 'locale',
    'uses' => 'LanguagesController@back',
]);
