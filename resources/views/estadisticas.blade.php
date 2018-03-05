<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>PUCE - Dirección General de Estudiantes</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
</head>
<body>
<div id="app">
    <header>
        <nav class="nav-extended light-blue lighten-2" style="padding-top: 10px">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo" style="margin-left: 15px"><img src="{{asset('img/logo_bolsa_blanco.svg')}}" height="60px" ></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
            <div class="nav-content">
                <ul class="tabs tabs-transparent">
                    <li class="tab"><a class="active" href="#organizaciones">Organizaciones</a></li>
                    <li class="tab"><a href="#hojasDeVida">Hojas de Vida</a></li>
                    <li class="tab"><a href="#ofertasIngresadas">Ofertas Ingresadas</a></li>
                    <li class="tab"><a href="#ofertasVigentes">Ofertas Vigentes</a></li>
                    <li class="tab"><a href="#aplicantes">Aplicantes</a></li>
                    <li class="tab"><a href="#contratados">Contratados</a></li>
                </ul>
            </div>
        </nav>
        <div style="margin: 20px 10px 10px 20px">
            <div id="organizaciones" class="col s12 animated fadeIn">
                <estadisticas></estadisticas>
                <div class="fixed-action-btn toolbar">
                    <a class="btn-floating btn-large  light-blue darken-4">
                        <i class="large material-icons">add</i>
                    </a>
                    <ul>
                        <li class="waves-effect waves-light"><a href="#!">Por nombre</a></li>
                        <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">format_quote</i></a></li>
                        <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">publish</i></a></li>
                        <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">attach_file</i></a></li>
                    </ul>
                </div>
            </div>
            <div id="hojasDeVida" class="col s12 animated fadeIn">Test 2</div>
            <div id="ofertasIngresadas" class="col s12 animated fadeIn">Test 2</div>
            <div id="ofertasVigentes" class="col s12 animated fadeIn">Test 3</div>
            <div id="aplicantes" class="col s12 animated fadeIn">Test 4</div>
            <div id="contratados" class="col s12 animated fadeIn">Test 4</div>
        </div>
    </header>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<script src="{{mix('js/app.js')}}"></script>
</body>
</html>
