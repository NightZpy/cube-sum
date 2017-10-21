<?php

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

Route::get('/', function () {
    return view('form');
});

Route::post('/make-cube', 'CubesController@store')->name('cube.store');
Route::post('/update', 'CubesController@updateCmd');
Route::post('/query', 'CubesController@queryCmd');