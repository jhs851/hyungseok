<?php

Route::name('api.')->group(function () {
    // Tags
    Route::get('tags', [
        'as' => 'tags.index',
        'uses' => 'TagsController@index',
    ]);
});
