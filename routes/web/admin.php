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
        Route::resource('developments', 'DevelopmentsController')->only('index');
    });
});
