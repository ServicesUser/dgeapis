<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;
use Unirest\Request as Unirest;

class QuitoController extends Controller{
    public function show($cedula){
        Unirest::verifyPeer(false);
        $response = Unirest::get("https://www.puce.edu.ec/intranet/servicios/datos/infoestudiante/cedula/$cedula",
            [
                "accept"            =>  "rest",
                "referer"           =>  "https://www.puce.edu.ec/intranet/servicios/datos/infoestudiante/cedula/$cedula"
            ]
        );
        if($response->headers['Content-Type']==='application/json')
            return ($response->body);
        else{
            return (['val'=>false]);
        }
    }

}
