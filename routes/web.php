<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// COOKIE RELATED
Route::post('/cookie/set', 'CookieController@setCookie')->name('set-cookie');
Route::post('/cookie/get', 'CookieController@getCookie')->name('get-cookie');
Route::post('/cookie/delete', 'CookieController@deleteCookie')->name('del-cookie');

// HOME PAGE
Route::get('/', 'PageController@index')->name('home');