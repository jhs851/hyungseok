<?php

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

Route::post('/images', [
    'as' => 'images.store',
    'uses' => 'UploadImagesController@store',
]);
