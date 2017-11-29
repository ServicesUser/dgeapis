<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Unirest\Request as Unirest;

class Autenticacion extends Controller{
    public function token_quito($id){
        $response = Unirest::get("https://www.puce.edu.ec/intranet/servicios/datos/usuario/id/$id",
            [
                "Accept" => "application/json"
            ]
        );
        return($response->body);
    }
}
