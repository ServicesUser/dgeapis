<?php

namespace App\Http\Controllers;

use App\Manabi\Estudiante;
use Illuminate\Http\Request;

class ManabiController extends Controller{

    public function show($cedula){
        $lista = ['val'=>false,'menssage'=>'No existen resultados'];
        $resultado =    Estudiante::select('id_cm as carrera','nombres_m as nombres','email_m as email','usuario_m as usuario','porcentaje_m as porcentaje','ci_m as ci')->where('ci_m',$cedula)->get();
        if(count($resultado)){
            $lista=$resultado;
        }
        return $lista;
    }
}
