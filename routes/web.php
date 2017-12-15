<?php

Route::group(['namespace' => 'InetStudio\Polls\Http\Controllers\Back'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'back'], function () {
        Route::group(['middleware' => 'back.auth'], function () {
            Route::any('polls/data', 'PollsController@data')->name('back.polls.data');
            Route::post('polls/suggestions', 'PollsController@getSuggestions')->name('back.polls.getSuggestions');
            Route::post('polls/info', 'PollsController@getInfo')->name('back.polls.info');
            Route::resource('polls', 'PollsController', ['except' => [
                'show',
            ], 'as' => 'back']);
        });
    });
});
