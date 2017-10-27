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

Route::get('/ambato/estudiantes/{cedula}','AmbatoController@show');


//--manabi
Route::get('/manabi/estudiantes/{cedula}','ManabiController@show');



//--ambato
Route::get('prueba','AmbatoController@prueba');
