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

// Best Comment
Route::post('/comments/{comment}/best', [
    'as' => 'best-comments.store',
    'uses' => 'BestCommentsController@store',
]);

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
Route::resource('/users', 'UsersController')->only(['index', 'show']);

// Notifications
Route::resource('/users/{user}/notifications', 'UserNotificationsController')->only(['index', 'destroy']);

// Avatars
Route::post('/users/{user}/avatar', [
    'as' => 'users.avatar.store',
    'uses' => 'AvatarsController@store',
]);
Route::delete('/users/{user}/avatar', [
    'as' => 'users.avatar.destroy',
    'uses' => 'AvatarsController@destroy',
]);
