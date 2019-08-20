<?php

// Authenticate
Auth::routes(['verify' => true]);

// Social
Route::view('/social/invalid', 'auth.social.invalid');
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

// Privacy
Route::get('/privacy', [
    'as' => 'privacy',
    'uses' => function () {
        return view('auth.privacy');
    },
]);

// Terms
Route::get('/terms', [
    'as' => 'terms',
    'uses' => function () {
        return view('auth.terms');
    },
]);
