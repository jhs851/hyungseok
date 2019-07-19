<?php

Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
    Route::get('/', [
        'as' => 'login',
        'uses' => 'AdminLoginController@showLoginForm',
    ]);

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [
            'as' => 'dashboard',
            'uses' => 'AdminController',
        ]);
    });
});
