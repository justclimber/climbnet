<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('/climbs', 'ClimbSessionController@index');
    Route::get('/climbs/my', 'ClimbSessionController@myclimbs');
    Route::get('/climbs/{climbSession}', 'ClimbSessionController@show')
        ->where('climbSession', '[0-9]+');

    Route::post('/climbs', 'ClimbSessionController@store');

    Route::post('/climbed-routes', 'ClimbedRouteController@store');
});

Route::get('/settings', 'SettingsController@index');
Route::post('/session', 'SessionController@store');
