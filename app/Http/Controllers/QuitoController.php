<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;
use Unirest\Request as Unirest;

class QuitoController extends Controller{
    public function show($cedula){
        $response = Unirest::get("https://www.puce.edu.ec/intranet/servicios/datos/infoestudiante/cedula/$cedula",
            [
                "Accept" => "application/json"
            ]
        );
        return ([$response]);
    }
}
