<?php

namespace App\Http\Controllers;

use App\SDomingo\Estudiante;
use Illuminate\Http\Request;

class SDomingoController extends Controller{
    public function show($cedula){
        $lista = ['val'=>false,'menssage'=>'No existen resultados'];
        $resultado =    Estudiante::select('id_cs as carrera','nombres_s as nombres','nombre_s as nombre','apellido_s as apellido','email_s as email','usuario_s as usuario','porcentaje_s as porcentaje','ci_s as ci','celular_s as celular')->where('ci_s',$cedula)->get();
        if(count($resultado)){
            $lista=$resultado;
        }
        return $lista;
    }
}
