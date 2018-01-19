<?php

Route::group(['namespace' => 'InetStudio\Polls\Http\Controllers\Back'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'back'], function () {
        Route::group(['middleware' => 'back.auth'], function () {
            Route::any('polls/data', 'PollsController@data')->name('back.polls.data');
            Route::any('polls/analytics/data', 'PollsController@analyticsData')->name('back.polls.analytics.data');
            Route::post('polls/suggestions', 'PollsController@getSuggestions')->name('back.polls.getSuggestions');
            Route::post('polls/info', 'PollsController@getInfo')->name('back.polls.info');
            Route::get('polls/analytics', 'PollsController@getAnalytics')->name('back.polls.analytics');
            Route::get('polls/analytics/results/{id}', 'PollsController@getPollResults')->name('back.polls.analytics.results');
            Route::resource('polls', 'PollsController', ['except' => [
                'show',
            ], 'as' => 'back']);
        });
    });
});
