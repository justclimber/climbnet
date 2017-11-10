<?php
// @todo: fix the 404 for api
Route::view('/{route?}', 'landing')->where('route', '.+');
