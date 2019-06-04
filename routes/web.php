<?php

// Homepage
Route::get('/', [
    'as'   => 'home',
    'uses' => 'HomeController',
]);

// Localization
Route::get('/js/languages.js', [
    'as'   => 'assets.lang',
    'uses' => 'LanguagesController',
]);

// Development posts
Route::resource('developments', 'DevelopmentsController');

// Authenticate
Auth::routes(['verify' => true]);
