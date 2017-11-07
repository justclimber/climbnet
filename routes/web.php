<?php

Route::view('/', 'landing');
Route::view('/climbs/{id}', 'landing');
Route::view('/climbs/{id}/routes/{route_id}', 'landing');
