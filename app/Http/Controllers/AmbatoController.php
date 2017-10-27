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
            $a['cedula']=$item->NumerodeCedulaoPasaporte;
            $a['nombres']=$item->NombresCompletos;
            $a['carrera']=$item->Carrera;
            $a['estado']=$item->Status;
            $aux[]=$a;
        }
        return $aux;


    }
}
