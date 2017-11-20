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




//--manabi
Route::get('/manabi/estudiantes/{cedula}','ManabiController@show');

//--santo domingo
Route::get('/sdomingo/estudiantes/{cedula}','SDomingoController@show');

//--ambato
Route::get('/ambato/estudiantes/{cedula}'  ,'AmbatoController@show');
Route::get('/ambato/actualizar','AmbatoController@actualizar');


//--esmeraldas
Route::get('/esmeraldas/estudiantes/{cedula}'  ,'EsmeraldasController@show');

//--ibarra
Route::get('/ibarra/estudiantes/{cedula}'  ,'IbarraController@show');