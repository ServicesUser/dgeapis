<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultaInterface extends Controller{
    private function historial($valor=null,$resultado=null){
        $var = @session(['historial']);
        if(!$valor && $resultado!==null){
            $var[] = ['ci'=>$valor,'res'=>$resultado];
            session(['historial' => $var]);
        }
        return $var;
    }
    public function index(){
        return view('cedula');
    }
    public function show($dni){
        $resultado = app('App\Http\Controllers\QuitoController')->show($dni);
        $sede = "PUCE";
        if(isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\AmbatoController')->show($dni);
            $sede = "PUCESA";
        }elseif (isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\EsmeraldasController')->show($dni);
            $sede = "PUCESE";
        }elseif (isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\IbarraController')->show($dni);
            $sede = "PUCESI";
        }elseif (isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\ManabiController')->show($dni);
            $sede = "PUCEM";
        }elseif (isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\SDomingoController')->show($dni);
            $sede = "PUCESD";
        }
        return $resultado;

        //return view('cedula');

    }
}
