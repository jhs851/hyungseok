<?php

Route::name('api.')->group(function () {
    Route::get('tags', [
        'as' => 'tags.index',
        'uses' => 'TagsController@index',
    ]);
});
