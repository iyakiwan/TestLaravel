<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('kas','ArusKasController@index');
Route::get('/kas/labarugi','ArusKasController@labaRugi');
Route::get('/kas/{id}','ArusKasController@detail');
Route::post('/kas/masuk','ArusKasController@createMasuk');
Route::post('/kas/keluar','ArusKasController@createKeluar');
