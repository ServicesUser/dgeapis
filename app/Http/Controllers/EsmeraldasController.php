<?php

namespace App\Http\Controllers;

use App\Carreras;
use App\Esmeraldas\Carrera;
use App\Esmeraldas\Estudiante;
use App\Esmeraldas\Facultad;
use App\Facultades;
use Illuminate\Http\Request;
use Unirest\Request as Unirest;


class EsmeraldasController extends Controller{

    protected $universidad=5;

    public function buscar($cedula){
        $response = Unirest::get("https://intranet.pucese.edu.ec/api/web/v1/backend/graduados-or-egresados",
            [
                "Accept" => "application/json"
            ],
            [
                "access-token"  =>  'dS0ryijUrDYsI-eX-r34qV28MHWQ-5Gr',
                "cedula"        =>  $cedula
            ]
        );
        $b=[];
        if($response && $response->body->name!=='Unauthorized'){
            foreach ($response->body as $item){
                $a['nombres']   =   mb_convert_case($item->NOMBRES_COMPLETOS, MB_CASE_TITLE);
                $a['nombre']    =   mb_convert_case($item->NOMBRES, MB_CASE_TITLE);
                $a['apellido']  =   mb_convert_case($item->APELLIDOS, MB_CASE_TITLE);
                $a['cedula']    =   $item->CEDULA;
                $a['carrera']   =   $this->codigoCarrera($item->ESPECIALIDAD,'SEDE ESMERALDAS');

                $estudiante     =   Estudiante::where('ci_e',$a['cedula'])->where('id_ce',$a['carrera'])->first();
                if(!$estudiante){
                    $estudiante             =   new Estudiante();
                    $estudiante->id_ce      =   $a['carrera'];
                    $estudiante->nombres_e  =   $a['nombres'];
                    $estudiante->nombre_e   =   $a['nombre'];
                    $estudiante->apellido_e =   $a['apellido'];
                    $estudiante->ci_e       =   $a['cedula'];
                    $estudiante->save();
                }
                $b[]=$a;
            }
        }
        return $b;
    }

    public function show($cedula){
        $this->buscar($cedula);
        $lista = ['val'=>false,'menssage'=>'No existen resultados'];
        $resultado   =   Estudiante::select('carreras_e.id_ce as carrera','nombre_ce as carreran','nombres_e as nombres','celular_e as celular','telefono_e as telefono','sexo_e as sexo','porcentaje_e as porcentaje','ci_e as cedula','expediente_e as expediente','nivel_e as nivel','id_fe as facultad','pregrado_ce as pregrado')
            ->join('carreras_e','carreras_e.id_ce','=','esmeraldas.id_ce')
            ->where('ci_e',$cedula)->get();
        if(count($resultado)){
            $lista=$resultado;
        }
        return $lista;
    }

    private function codigoCarrera($carrera,$facultad,$tipo='PREGRADO'){
        $carrera=mb_convert_case($carrera, MB_CASE_TITLE);
        if($carrera){
            $carreras   =   Carreras::join('facultades','escuelas.ID_FAC','=','facultades.ID_FAC')->where('NOMBRE_ESC',$carrera)->where('ID_UNIVERSIDAD',$this->universidad)->first();
            if(!$carreras){
                $carreras               =   new Carreras();
                $carreras->NOMBRE_ESC   =   $carrera;
                $carreras->ID_FAC       =   $this->codigoFacultad($facultad);
                $carreras->TIPO_ESC     =   $tipo;
                $carreras->save();

                $carinterna             =   new Carrera();
                $carinterna->id_fe      =   $carreras->ID_FAC;
                $carinterna->id_ce      =   $carreras->CODIGO_ESC;
                $carinterna->nombre_ce  =   $carrera;
                $carinterna->save();
            }
            return $carreras->CODIGO_ESC;
        }
        return false;
    }
    private function codigoFacultad($facultad){
        $facultad=mb_convert_case($facultad, MB_CASE_TITLE);
        if($facultad){
            $facultades =   Facultades::where('ID_UNIVERSIDAD',$this->universidad)->where('NOMBRE_FAC',$facultad)->first();
            if(!$facultades){
                $facultades                 =   new Facultades();
                $facultades->NOMBRE_FAC     =   $facultad;
                $facultades->ID_UNIVERSIDAD =   $this->universidad;
                $facultades->save();

                $facinterna                 =   new Facultad();
                $facinterna->id_fe          =   $facultades->ID_FAC;
                $facinterna->nombre_fe      =   $facultad;
                $facinterna->save();
            }
            return $facultades->ID_FAC;
        }
        return false;
    }
}
