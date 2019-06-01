<?php

Route::get('/', [
    'as'   => 'home',
    'uses' => 'HomeController',
]);

Route::resource('developments', 'DevelopmentsController');

Auth::routes(['verify' => true]);

if (Route::has('developments.index')) {
    Route::redirect('/home', route('developments.index'));
}
