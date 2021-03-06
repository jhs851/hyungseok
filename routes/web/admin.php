<?php

Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
    // Authenticate
    Route::get('/', [
        'as' => 'login',
        'uses' => 'AdminLoginController@showLoginForm',
    ]);
    Route::post('/', 'AdminLoginController@login');

    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('dashboard', [
            'as' => 'dashboard',
            'uses' => 'AdminController',
        ]);

        // Developments
        Route::resource('developments', 'DevelopmentsController');

        // Comments
        Route::post('/developments/{development}/comments', [
            'as' => 'comments.store',
            'uses' => 'CommentsController@store',
        ]);
        Route::resource('comments', 'CommentsController')->only(['index', 'update', 'destroy']);

        // Tags
        Route::resource('tags', 'TagsController')->except(['show', 'edit']);

        // Favorites
        Route::resource('favorites', 'FavoritesController')->only(['index', 'destroy']);

        // Notifications
        Route::delete('notifications/{notification}/mark', [
            'as' => 'notifications.mark',
            'uses' => 'NotificationsController@mark',
        ]);
        Route::resource('notifications', 'NotificationsController');

        // Users
        Route::resource('users', 'UsersController');
    });
});
