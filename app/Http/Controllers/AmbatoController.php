<?php

namespace App\Http\Controllers;

use App\Ambato\Estudiante;
use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\SoapWrapper;


class AmbatoController extends Controller{

    protected $soapWrapper;

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
    public function prueba(){
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
            $a['facultad']      =   $item->facultad;
            $a['nacimiento']    =   $item->nacimiento;
            $a['telefono']      =   $item->telefono;
            $a['celular']       =   $item->celular;
            $a['sexo']          =   $item->sexo;
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
}
