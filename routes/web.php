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

// Authenticate
Auth::routes(['verify' => true]);

// Social
Route::get('/social/{provider}', [
    'as' => 'social.login',
    'uses' => 'Auth\SocialController@execute',
]);

// Development posts
Route::resource('/developments', 'DevelopmentsController')->except('edit');

// Comments
Route::post('/developments/{development}/comments', [
    'as' => 'comments.store',
    'uses' => 'CommentsController@store',
]);
Route::resource('/comments', 'CommentsController')->only(['update', 'destroy']);

// Favorites
Route::post('/developments/{development}/favorite', [
    'as' => 'favorites.store',
    'uses' => 'FavoritesController@store',
]);
Route::delete('/developments/{development}/favorite', [
    'as' => 'favorites.destroy',
    'uses' => 'FavoritesController@destroy',
]);

// Users
Route::get('/users/{user}', [
    'as' => 'users.show',
    'uses' => 'UsersController@show',
]);

// Notifications
Route::resource('/users/{user}/notifications', 'UserNotificationsController')->only(['index', 'destroy']);