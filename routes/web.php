<?php

use Illuminate\Support\Facades\Auth;

Route::group([
    'as'         => 'frontend.',
    'prefix'     => '',
    'namespace'  => 'Partymeister\Frontend\Http\Controllers\Frontend',
    'middleware' => [
        'web',
        'web_auth'
    ]
], function () {
});

Route::group([
    'as'         => 'frontend.',
    'prefix'     => '',
    'namespace'  => 'Partymeister\Frontend\Http\Controllers\Frontend',
    'middleware' => [
        'web',
    ]
], function () {
	Route::get('visitors', 'VisitorsController@index')->name('visitors');
	Route::get('timetable', 'TimetableController@index')->name('timetable');
    Route::get('home', 'FrontendController@index')->name('home');
    Route::get('photos', 'PhotowallController@index')->name('photowall');
    Route::get('items', 'ItemsController@index')->name('items');
    Route::get('releases', 'ReleasesController@index')->name('releases.index');
    Route::get('votes', 'VotesController@index')->name('votes.index');
    Route::post('votes', 'VotesController@store')->name('votes.store');
    Route::get('comments/{entry}', 'Entries\CommentsController@index')->name('comments.index');
    Route::post('comments/{entry}', 'Entries\CommentsController@store')->name('comments.store');
    Route::get('entries/{entry}/screenshot/edit', 'Entries\ScreenshotController@edit')->name('entries.screenshot.edit');
    Route::patch('entries/{entry}/screenshot', 'Entries\ScreenshotController@update')->name('entries.screenshot.update');
    Route::get('entries/{entry}/screenshot/edit', 'Entries\ScreenshotController@edit')->name('entries.screenshot.edit');
    Route::patch('entries/{entry}/screenshot', 'Entries\ScreenshotController@update')->name('entries.screenshot.update');
    Route::resource('entries', 'EntriesController')->except(['delete']);
    Route::get('voting/live', 'LiveVotingController@index')->name('voting.live');
});

Route::group([
    'prefix'     => 'visitor',
    'middleware' => [ 'web' ],
    'namespace'  => 'Partymeister\Frontend\Http\Controllers'
], function () {
    Auth::routes();
});
