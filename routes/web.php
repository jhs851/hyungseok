<?php

Route::get('/', [
    'as'   => 'home',
    'uses' => 'HomeController',
]);

Route::resource('developments', 'DevelopmentsController');
