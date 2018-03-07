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
    public function ofertas(){
        $a['lista']         =   DB::connection('basep')->select('SELECT TITULO_REQ titulo,REMUNERACION_REQ estipendio,NOMBRE_EMP empresa,FECHAC_REQ fecha_publicacion,NOMBRE_TR tipo FROM requerimientos natural join empresas natural join tipos_req order by FECHAC_REQ');
        $a['tipo']          =   DB::connection('basep')->select('SELECT NOMBRE_TR name,ID_TR codigo,(select count(*) from requerimientos where ID_TR=codigo) y from tipos_req');
        return $a;
    }
    public function ofertasVigentes(){
        $a['lista']         =   DB::connection('basep')->select('SELECT TITULO_REQ titulo,REMUNERACION_REQ estipendio,NOMBRE_EMP empresa,FECHAC_REQ fecha_publicacion,NOMBRE_TR tipo FROM requerimientos natural join empresas natural join tipos_req where ESTADO_REQ=1 order by FECHAC_REQ');
        $a['tipo']          =   DB::connection('basep')->select('SELECT NOMBRE_TR name,ID_TR codigo,(select count(*) from requerimientos where ID_TR=codigo AND ESTADO_REQ=1) y from tipos_req');
        return $a;
    }

}
