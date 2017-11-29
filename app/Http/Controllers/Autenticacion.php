<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Unirest\Request as Unirest;

class Autenticacion extends Controller{
    public function token_quito($id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.puce.edu.ec/intranet/servicios/datos/usuario/id/$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 4b608e15-36de-e913-2766-cfa1f590aade"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return json_decode($response);
        }
    }
}
