<?php

namespace App\Http\Controllers;

use App\Estudiantes;
use Illuminate\Http\Request;

class ConsultaInterface extends Controller{
    private function historial($valor=null,$resultado=null){
        $var = session('historial');
        if($var){
            $var->push(collect(['ci'=>$valor,'res'=>$resultado]));
            session(['historial' => $var]);
        }else{
            session(['historial' => collect(['ci'=>$valor,'res'=>$resultado])]);
        }
        return session('historial');
    }
    public function index(){
        return view('cedula');
    }
    public function show($dni){
        $resultado = app('App\Http\Controllers\QuitoController')->show($dni);

        if(isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\AmbatoController')->show($dni);
            $sede = "PUCESA";
            $nombres = @$resultado[0]['nombres'];
        }else{
            $sede = "PUCE";
            $nombres = $resultado[0]->nombre;
            foreach ($resultado as $item){
                $impedimentos       =   ($item->impedimento==="N"?false:true);
                $aux['carrera']     =   $item->carrera;
                $aux['facultad']    =   $item->facultad;
                $aux['aprobacion']  =   $item->porcentaje;
                $carrera[]          =   $aux;
            }


        }
        if (isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\EsmeraldasController')->show($dni);
            $sede = "PUCESE";
            $nombres = @$resultado[0]['nombres'];
        }
        if (isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\IbarraController')->show($dni);
            $sede = "PUCESI";
            $nombres = @$resultado[0]['nombres'];
        }
        if (isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\ManabiController')->show($dni);
            $sede = "PUCEM";
            $nombres = @$resultado[0]['nombres'];
        }
        if (isset($resultado['val'])){
            $resultado = app('App\Http\Controllers\SDomingoController')->show($dni);
            $sede = "PUCESD";
            $nombres = @$resultado[0]['nombres'];
        }
        $estudiante             =   Estudiantes::find($dni);



        $auxiliar['sede']           =   $sede;
        $auxiliar['nombres']        =   $nombres;
        $auxiliar['val']            =   (@$resultado['val']===false?false:true);
        $auxiliar['cuenta']         =   count($estudiante);
        $auxiliar['email']          =   @$estudiante->MAIL_EST;
        $auxiliar['foto1']          =   'http://be.dgepuce.edu.ec/estudiantes/fotos-estudiantes/'.md5(md5(@$estudiante->CI_EST)).'.jpg';
        $auxiliar['foto2']          =   'http://be.dgepuce.edu.ec/estudiantes/fotos-estudiantes/'.md5(md5(@$estudiante->CI_EST)).'.jpeg';
        $auxiliar['impedimentos']   =   @$impedimentos;
        $auxiliar['carrera']        =   @$carrera;
        $auxiliar['historial']      =   $this->historial($dni,$auxiliar['val']);

        //return $auxiliar;
        return view('cedula',['datos'=>$auxiliar]);

    }
}
