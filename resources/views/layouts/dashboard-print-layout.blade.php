<!DOCTYPE html>
<!-- Breadcrumb-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <base href="./">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Seguimiento de proyectos electricos">
    <meta name="author" content="Jair Cussy">
    <meta name="keyword" content="serebo">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{asset('coreui/assets/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('coreui/assets/favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    @vite('resources/css/serebo.dashboard-print.css')
</head>
<body>
    <!-- Menu -->
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <!-- Navbar -->
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    @vite('resources/js/serebo.dashboard-print.core.js')
</body>
</html>
