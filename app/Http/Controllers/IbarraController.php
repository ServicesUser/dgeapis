<?php

namespace App\Http\Controllers;

use App\Ibarra\Estudiante;
use Illuminate\Http\Request;

class IbarraController extends Controller{
    public function show($cedula){
    $lista = ['val'=>false,'menssage'=>'No existen resultados'];
    $resultado =    Estudiante::select('id_ci as carrera','nombres_i as nombres','nombre_i as nombre','apellido_i as apellido','email_i as email','usuario_i as usuario','porcentaje_i as porcentaje','ci_i as ci','celular_i as celular')->where('ci_i',$cedula)->get();
    if(count($resultado)){
        $lista=$resultado;
    }
    return $lista;
}
}
