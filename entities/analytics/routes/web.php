<?php

Route::group([
    'namespace' => 'InetStudio\PollsPackage\Analytics\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('polls/analytics/data', 'DataControllerContract@data')->name('back.polls.analytics.data.index');
    Route::get('polls/analytics/result/{id}', 'AnalyticsControllerContract@getPollResult')->name('back.polls.analytics.result');

    Route::get('polls/analytics', 'AnalyticsControllerContract@index')->name('back.polls.analytics.index');
});
