<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link href="/dashboard/images/favicon.png" rel="icon" type="image/png" /> -->
    <title>@yield('title','ALMACEN | GADBENI')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('theme/plugins/fontawesome-free/css/all.min.css')}}">
    @stack('styles')
    <!-- Theme pace -->
    <link rel="stylesheet" href="{{asset('theme/dist/css/pace-blue/pace-theme-flash.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('theme/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <style>
        body {
            background-color: #BACCCC;
            /*font-family: Times New Roman, Times, serif;
            font-size: 10pt;*/
        }
    </style>
</head>
<body class="layout-top-nav">
    <div class="wrapper">
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <!-- <nav class="navbar navbar-expand navbar-info navbar-dark"> -->
            <!-- <nav class="navbar navbar-expand navbar-info navbar-light"> -->
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <img src="{{asset('theme/dist/img/logo.png')}}" class="img-circle elevation-3" style="width: 50px; height: 50px">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    @include('layouts.partials.navbar')

                </div>
            </nav>
            @include('sweetalert::alert')
            <main class="py-4">
                @yield('content')
            </main>

            {{-- Pie de Página --}}
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                  SisAlmacen V.2.0
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2021 <a href="javascript:void(0);">Dirección de Sistemas y Telecomunicaciones</a>.</strong> Todos los Derechos Reservados.
            </footer>

        </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('theme/plugins/jquery/jquery.min.js')}}"></script>
    @yield('script')
    @stack('script')
    <!-- Pace -->
    <script src="{{asset('theme/dist/js/pace.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('theme/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
