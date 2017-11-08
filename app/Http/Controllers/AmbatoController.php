<?php

namespace App\Http\Controllers;

use App\Ambato\Carrera;
use App\Ambato\Estudiante;
use App\Ambato\Facultad;
use App\Carreras;
use App\Facultades;
use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\SoapWrapper;


class AmbatoController extends Controller{

    protected $soapWrapper;

    protected $universidad=4;

    /**
     * SoapController constructor.
     *
     * @param SoapWrapper $soapWrapper
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    public function show($cedula){
        $lista = ['val'=>false,'menssage'=>'No existen resultados'];
        $resultado   =   Estudiante::select('carreras_a.id_ca as carrera','nombre_ca as carreran','nombres_a as nombres','celular_a as celular','telefono_a as telefono','sexo_a as sexo','usuario_a as modalidad','porcentaje_a as porcentaje','ci_a as cedula','expediente_a as expediente','nivel_a as nivel','id_fa as facultad','pregrado_ca as pregrado')
                                    ->join('carreras_a','carreras_a.id_ca','=','ambato.id_ca')
                                    ->where('ci_a',$cedula)->get();
        if(count($resultado)){
            $lista=$resultado;
        }
        return $lista;
    }



    public function actualizar(){
        ini_set('max_execution_time', 120);
        $this->soapWrapper->add('Currency', function ($service) {
            $service
                ->wsdl('http://app.pucesa.edu.ec:9080/ServiciosAcademics/wsBolsaTrabajoQuito.asmx?WSDL')
                ->trace(true)
                ->classmap([
                    GetConversionAmount::class,
                    GetConversionAmountResponse::class,
                ]);
        });
        $response = $this->soapWrapper->call('Currency.GetDatosBolsaTrabajo')->GetDatosBolsaTrabajoResult->ViewEstructuraBolsaTrabajoQuito;
        $aux    =   [];
        foreach ($response as $item){
            $a['cedula']        =   $item->cedula;
            $a['anio']          =   $item->anio;
            $a['nombres']       =   mb_convert_case($item->nombre, MB_CASE_TITLE,'UTF-8');
            $a['porcentaje']    =   (int)$item->porcentaje;
            $a['carrera']       =   $this->codigoCarrera($item->carrera,$item->facultad,$item->preposgrado);
            $a['carreran']      =   $item->carrera;
            $a['facultad']      =   $item->facultad;
            $a['nacimiento']    =   $item->nacimiento;
            $a['telefono']      =   ($item->telefono==="NN"?null:$item->telefono);
            $a['celular']       =   ($item->celular==="NN"?null:$item->celular);
            $a['sexo']          =   ($item->sexo==='F'?0:1);
            $a['plan']          =   ($item->plan===''?null:$item->plan);
            $a['expediente']    =   ($item->expediente===''?null:$item->expediente);
            $a['impedimento']   =   ($item->impedimento==="N"?false:true);
            $a['nivel']         =   $item->nivel;
            $a['modalidad']     =   $item->modalidad;
            $a['pregrado']      =   ($item->preposgrado==="PREGRADO"?true:false);
            $a['actualizacion'] =   ($item->actualizacion==="TRUE"?true:false);

            $estudiante =   Estudiante::where('ci_a',$a['cedula'])->where('id_ca',$a['carrera'])->first();
            if(!$estudiante){
                $estudiante =   new Estudiante();
                $estudiante->id_ca          =   $a['carrera'];
                $estudiante->ci_a           =   $a['cedula'];
                $estudiante->nombres_a      =   $a['nombres'];
                $estudiante->celular_a      =   $a['celular'];
                $estudiante->telefono_a     =   $a['telefono'];
                $estudiante->sexo_a         =   $a['sexo'];
                $estudiante->porcentaje_a   =   $a['porcentaje'];
                $estudiante->plan_a         =   $a['plan'];
                $estudiante->expediente_a   =   $a['expediente'];
                $estudiante->nivel_a        =   $a['nivel'];
                $estudiante->usuario_a      =   $a['modalidad'];//no hay un campo para modalidad
                $estudiante->save();
            }else{
                Estudiante::where('ci_a',$a['cedula'])->where('id_ca',$a['carrera'])->update(['porcentaje_a'=>$a['porcentaje'],'nivel_a'=>$a['nivel']]);
            }
            $aux[]=$a;
        }
        return $aux;
    }
    public function codigoCarrera($carrera,$facultad,$tipo){
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
                $carinterna->id_fa      =   $carreras->ID_FAC;
                $carinterna->id_ca      =   $carreras->CODIGO_ESC;
                $carinterna->nombre_ca  =   $carrera;
                $carinterna->save();
            }
            return $carreras->CODIGO_ESC;
        }
        return false;
    }
    public function codigoFacultad($facultad){
        $facultad=mb_convert_case($facultad, MB_CASE_TITLE);
        if($facultad){
            $facultades =   Facultades::where('ID_UNIVERSIDAD',$this->universidad)->where('NOMBRE_FAC',$facultad)->first();
            if(!$facultades){
                $facultades                 =   new Facultades();
                $facultades->NOMBRE_FAC     =   $facultad;
                $facultades->ID_UNIVERSIDAD =   $this->universidad;
                $facultades->save();

                $facinterna                 =   new Facultad();
                $facinterna->id_fa          =   $facultades->ID_FAC;
                $facinterna->nombre_fa      =   $facultad;
                $facinterna->save();
            }
            return $facultades->ID_FAC;
        }
        return false;
    }
}
