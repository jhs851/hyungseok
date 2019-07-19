<?php

// Authenticate
Auth::routes(['verify' => true]);

// Social
Route::get('/social/{provider}', [
    'as' => 'social.login',
    'uses' => 'Auth\SocialController@execute',
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
