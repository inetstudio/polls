<?php

Route::group(['namespace' => 'InetStudio\Polls\Controllers'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'back'], function () {
        Route::group(['middleware' => 'back.auth'], function () {
            Route::any('polls/data', 'PollsController@data')->name('back.polls.data');
            Route::resource('polls', 'PollsController', ['except' => [
                'show',
            ], 'as' => 'back']);
        });
    });
});
