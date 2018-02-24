<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller{
    public function empresas(){
        $a['lista']         =   DB::connection('basep')->select('SELECT NOMBRE_EMP empresa,SECTORES_EMP sector,SUBSECTOR_EMP subsector,TIPOLOGIA_EMP tipo, FECHAC_EMP fecha FROM empresas where ESTADO_EMP=1 order by FECHAC_EMP');
        $a['sectores']      =   DB::connection('basep')->select('SELECT distinct(SECTORES_EMP) name,(select count(*) from empresas where SECTORES_EMP=name) y from empresas');
        $a['subsectores']   =   DB::connection('basep')->select('SELECT distinct(SUBSECTOR_EMP) name,(select count(*) from empresas where SUBSECTOR_EMP=name) y from empresas');
        $a['tipos']         =   DB::connection('basep')->select('SELECT distinct(TIPOLOGIA_EMP) name,(select count(*) from empresas where TIPOLOGIA_EMP=name) y from empresas');
        return $a;
    }
    public function hojasDeVida(){
        $a['lista']         =   DB::connection('basep')->select('SELECT NOMBRE_ESC name,count(NOMBRE_ESC) y FROM cv natural join inscribe natural join estudiantes natural join escuelas natural join facultades where ID_UNIVERSIDAD=1 group by name');
        $a['total']         =   collect(DB::connection('basep')->select('SELECT count(*) numero FROM cv natural join inscribe natural join estudiantes natural join escuelas natural join facultades where ID_UNIVERSIDAD=1'))->first();
        return $a;
    }
}
