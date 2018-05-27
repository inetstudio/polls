<?php

Route::group([
    'namespace' => 'InetStudio\Polls\Contracts\Http\Controllers\Back\Analytics',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('polls/analytics/data', 'PollsDataControllerContract@data')->name('back.polls.analytics.data.index');
    Route::get('polls/analytics/result/{id}', 'PollsControllerContract@getPollResult')->name('back.polls.analytics.result');

    Route::get('polls/analytics', 'PollsControllerContract@index')->name('back.polls.analytics.index');
});

Route::group([
    'namespace' => 'InetStudio\Polls\Contracts\Http\Controllers\Back\Polls',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('polls/data', 'PollsDataControllerContract@data')->name('back.polls.data.index');
    Route::post('polls/suggestions', 'PollsUtilityControllerContract@getSuggestions')->name('back.polls.getSuggestions');

    Route::resource('polls', 'PollsControllerContract', ['as' => 'back']);
});

Route::group([
    'namespace' => 'InetStudio\Polls\Contracts\Http\Controllers\Front\Polls',
    'middleware' => ['web'],
], function () {
    Route::post('polls/vote', 'PollsControllerContract@vote')->name('front.polls.vote');
});
