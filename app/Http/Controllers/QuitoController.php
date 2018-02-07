<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Unirest\Request as Unirest;

class QuitoController extends Controller{
    public function show($cedula){
        Unirest::verifyPeer(false);
        $response = Unirest::get("https://www.puce.edu.ec/intranet/servicios/datos/infoestudiante/cedula/$cedula",
            [
                "accept"            =>  "application/rest",
            ]
        );
        if($response->headers['Content-Type']==='application/json')
            return ($response->body);
        else{
            return (['val'=>false]);
        }
    }

    public function show2($token){
        Unirest::verifyPeer(false);
        $response = Unirest::get("https://www.puce.edu.ec/intranet/servicios/datos/usuario/id/$token",
            [
                "accept"            =>  "application/rest",
            ]
        );
        if($response->headers['Content-Type']==='application/json')
            return (collect($response->body));
        else
            return (['val'=>false]);
    }
}
