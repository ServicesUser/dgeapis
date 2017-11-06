<?php

namespace App\Http\Controllers;

use App\Ambato\Estudiante;
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
        $consulta   =   Estudiante::where('ci_a',$cedula)->get();
        return $consulta;
    }



    public function actualizar(){
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
            $a['nombres']       =   $item->nombre;
            $a['porcentaje']    =   (int)$item->porcentaje;
            $a['carrera']       =   $item->carrera;
            $a['carrera']       =   $item->carrera;
            $a['facultad']      =   $item->facultad;
            $a['nacimiento']    =   $item->nacimiento;
            $a['telefono']      =   ($item->telefono==="NN"?null:$item->telefono);
            $a['celular']       =   ($item->celular==="NN"?null:$item->celular);
            $a['sexo']          =   ($item->sexo==='F'?0:1);
            $a['plan']          =   $item->plan;
            $a['expediente']    =   $item->expediente;
            $a['impedimento']   =   ($item->impedimento==="N"?false:true);
            $a['nivel']         =   $item->nivel;
            $a['modalidad']     =   $item->modalidad;
            $a['pregrado']      =   ($item->preposgrado==="PREGRADO"?true:false);
            $a['actualizacion'] =   ($item->actualizacion==="TRUE"?true:false);
            $aux[]=$a;
        }
        return $aux;
    }
    public function codigoCarrera($carrera,$facultad){
        $carrera=ucfirst($carrera);
        if($carrera){
            $carreras   =   Carreras::join('facultades','escuelas.ID_FAC','=','facultades.ID_FAC')->where('NOMBRE_ESC',$carrera)->where('ID_UNIVERSIDAD',$this->universidad)->first();
            if(!$carreras){
                $carreras   = new Carreras();
                $carreras->NOMBRE_ESC   =   $carreras;
                $carreras->ID_FAC       = $this->codigoFacultad($facultad);
                $carreras->save();
            }
            return $carreras->CODIGO_ESC;
        }
        return false;
    }
    public function codigoFacultad($facultad){
        $facultad=ucfirst($facultad);
        if($facultad){
            $facultades =   Facultades::where('ID_UNIVERSIDAD',$this->universidad)->where('NOMBRE_FAC',$facultad)->first();
            if(!$facultades){
                $facultades                 =   new Facultades();
                $facultades->NOMBRE_FAC     =   $facultad;
                $facultades->ID_UNIVERSIDAD =   $this->universidad;
                $facultades->save();
            }
            return $facultades->ID_FAC;
        }
        return false;
    }
}
