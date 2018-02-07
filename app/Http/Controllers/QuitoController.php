<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Unirest\Request as Unirest;

class QuitoController extends Controller{
    public function show($cedula){
        Unirest::verifyPeer(false);
        $response = Unirest::get("https://www.puce.edu.ec/intranet/servicios/datos/infoestudiante/cedula/$cedula",
            [
              "accept"            =>  "rest",
              "postman-token"     =>  "3e4aabde-2190-47f7-991d-01cfacc3cac8",
              "user-agent"        =>  "PostmanRuntime/6.4.1",
              "cookie"            =>  "visid_incap_1482638=LPshB7BZTFioOlSh9/jgiwx0HFoAAAAAQUIPAAAAAACpdSKY2sJUnrZTYpt3Xggi; incap_ses_623_1482638=ym1gf6XK8R770ATum1elCHg3H1oAAAAAb4BATsFWnjuf6qrxpsc02Q==; incap_ses_994_1482638=oYMRbNkOZjTCBExwx2XLDaQBH1oAAAAApQS7gRTe9zmveMsldxyi8w==; ci_session=8a2ecada4ffed17cc7f16e2dbf077b6688bc811e",
              "cache-control"     =>  "no-cache",
              "accept-encoding"   =>  "gzip, defalte",
              "referer"           =>  "https://www.puce.edu.ec/intranet/servicios/datos/infoestudiante/cedula/$cedula"
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
              "accept"            =>  "rest",
              "referer"           =>  "https://www.puce.edu.ec/intranet/servicios/datos/usuario/id/$token"
            ]);
        if($response->headers['Content-Type']==='application/json')
            return (collect($response->body));
        else
            return (['val'=>false]);
    }
}
