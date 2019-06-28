<?php

Route::namespace('Api')->name('api.')->group(function () {
    Route::get('/users', [
        'as' => 'users.index',
        'uses' => 'UsersController@index',
    ]);
});

