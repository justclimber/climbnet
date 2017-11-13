<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('/climbs', 'ClimbSessionController@index');
    Route::get('/climbs/my', 'ClimbSessionController@myclimbs');
    Route::get('/climbs/{climbSession}', 'ClimbSessionController@show')
        ->where('climbSession', '[0-9]+');
    Route::put('/climbs/{climbSession}', 'ClimbSessionController@update')
        ->where('climbSession', '[0-9]+');

    Route::post('/climbs', 'ClimbSessionController@store');

    Route::post('/climbed-routes', 'ClimbedRouteController@store');
    Route::get('/climbed-routes/{climbedRoute}', 'ClimbedRouteController@show')
        ->where('climbedRoute', '[0-9]+');
    Route::put('/climbed-routes/{climbedRoute}', 'ClimbedRouteController@update')
        ->where('climbedRoute', '[0-9]+');
});

Route::get('/settings', 'SettingsController@index');
Route::post('/session', 'SessionController@store');
