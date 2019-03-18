<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('polls/data', 'DataControllerContract@data')->name('back.polls.data.index');
    Route::post('polls/suggestions', 'UtilityControllerContract@getSuggestions')->name('back.polls.getSuggestions');

    Route::resource('polls', 'ResourceControllerContract', ['as' => 'back']);
});

Route::group([
    'namespace' => 'InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Front',
    'middleware' => ['web'],
], function () {
    Route::post('polls/vote', 'PollsControllerContract@vote')->name('front.polls.vote');
});
