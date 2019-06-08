<?php

// Homepage
Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController',
]);

// Localization
Route::get('/js/languages.js', [
    'as' => 'assets.lang',
    'uses' => 'LanguagesController',
]);

// Development posts
Route::resource('developments', 'DevelopmentsController')->except('edit');

// Authenticate
Auth::routes(['verify' => true]);

// Social
Route::get('/social/{provider}', [
    'as' => 'social.login',
    'uses' => 'Auth\SocialController@execute',
]);
