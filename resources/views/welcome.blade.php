<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ALMACEN | GADBENI</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #154360;
                color: #fff;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #fff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Volver al Sistema</a>
                    @else
                        <a href="{{ route('login') }}">Iniciar Sesión - Almacenes</a>

<!--                         @if (Route::has('register'))
                            <a href="{{ route('register') }}">Registro</a>
                        @endif -->
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Almacenes - GADBENI
                </div>

                <div class="links">
                    <a href="https://www.beni.gob.bo/">Gobierno Autónomo Departamental del Beni</a>
                    <br>
                    <small>Copyright © 2020 Dirección de Sistemas y Telecomunicaciones. - Todos los Derechos Reservados.<br>Contacto: rhisita@beni.gob.bo</small>
                </div>
            </div>
        </div>
    </body>
</html>
