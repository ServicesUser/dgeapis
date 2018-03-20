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


//quito
Route::get('/quito/autenticacion/{token}','Autenticacion@token_quito');
Route::get('/quito/estudiantes/{cedula}','QuitoController@show');
Route::get('/quito/estudiantes/sesion/{token}','QuitoController@show2');



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




/*
 * Estadisticas
 *
 * */
Route::get('/estadisticas/empresas'  ,'EstadisticasController@empresas');
Route::get('/estadisticas/cvs'  ,'EstadisticasController@hojasDeVida');
Route::get('/estadisticas/ofertas'  ,'EstadisticasController@ofertas');
Route::get('/estadisticas/vigentes'  ,'EstadisticasController@ofertasVigentes');
Route::get('/estadisticas/aplicaciones'  ,'EstadisticasController@aplicaciones');
Route::get('/estadisticas/contratados'  ,'EstadisticasController@contratados');
