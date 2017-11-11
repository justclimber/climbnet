<?php
// this is SPAAAAA!!!!
Route::any('/{route}', 'LandingPageController@index')->where('route', '^(?!api\/).*');
