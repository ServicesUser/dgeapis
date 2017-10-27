<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PUCE - Dirección General de Estudiantes</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
    </head>
    <body>
    <div class="tagline-upper text-center text-heading text-shadow text-white mt-5 d-none d-lg-block"><img src="http://be.dgepuce.edu.ec/images/logo_puce.png" alt="puce"> Dirección General de Estudiantes</div>
    <div class="tagline-lower text-center text-expanded text-shadow text-uppercase text-white mb-5 d-none d-lg-block">Pontificia Universidad Católica del Ecuador</div>
    <nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-4">
        <div class="container">
            <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active px-lg-4">
                        <a class="nav-link text-uppercase text-expanded" href="#">Bolsa de Empleo
                            <span class="sr-only">(actual)</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="bg-faded p-4 my-4">
            <hr class="divider">
            <h2 class="text-center text-lg text-uppercase my-0">Sistema de Bolsa de Empleo y Pasantías <strong>PUCE</strong>
            </h2>
            <hr class="divider">
            <div class="list-group">
                <a href="http://be.dgepuce.edu.ec" class="list-group-item">PUCE</a>
                <a href="http://m.dgepuce.edu.ec" class="list-group-item">PUCEM</a>
                <a href="http://sd.dgepuce.edu.ec" class="list-group-item">PUCESD</a>
                <a href="http://sa.dgepuce.edu.ec" class="list-group-item">PUCESA</a>
                <a href="http://se.dgepuce.edu.ec" class="list-group-item">PUCESE</a>
                <a href="http://i.dgepuce.edu.ec" class="list-group-item">PUCEI</a>
            </div>
        </div>

    </div>
    <footer class="bg-faded text-center py-5">
        <div class="container">
            <p class="m-0">Copyright &copy; PUCE {{date('Y')}}</p>
        </div>
    </footer>
    <script src="{{mix('js/app.js')}}"></script>
    </body>
</html>
