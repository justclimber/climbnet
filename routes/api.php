<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/climbs', 'ClimbSessionController@index');
Route::get('/climbs/{climbSession}', 'ClimbSessionController@show')
    ->where('climbSession', '[0-9]+');

Route::post('/climbs', 'ClimbSessionController@store');
