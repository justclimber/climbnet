<?php
// this is SPAAAAA!!!!
Route::view('/{route}', 'landing')->where('route', '^(?!api\/).*');
