<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "App\Http\Controllers"], function() {
	//////////////////////////////
	// NON-AUTHENTICATED ROUTES //
	//////////////////////////////

	// Home Page
	Route::get('/', 'PageController@index')->name('home');
});
