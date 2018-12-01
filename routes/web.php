<?php

Route::group([
    'as'         => 'frontend.',
    'prefix'     => '',
    'namespace'  => 'Partymeister\Frontend\Http\Controllers\Frontend',
    'middleware' => [
        'web',
    ]
], function () {
    Route::get('photos', 'PhotowallController@index')->name('photowall');
});
