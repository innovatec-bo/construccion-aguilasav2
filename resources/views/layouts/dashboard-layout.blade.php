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
    <link rel="manifest" href="../coreui/assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../coreui/assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    {{-- <link rel="stylesheet" href="../coreui/vendors/simplebar/css/simplebar.css"> --}}
    {{-- <link rel="stylesheet" href="../coreui/css/vendors/simplebar.css"> --}}
    <!-- Main styles for this application-->
    {{-- <link href="../coreui/css/style.css" rel="stylesheet"> --}}
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css"> --}}
    {{-- <link href="../coreui/css/examples.css" rel="stylesheet"> --}}
    {{-- <link href="../coreui/vendors/@coreui/chartjs/css/coreui-chartjs.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ mix('css/serebo.dashboard.css') }}">
    @livewireStyles
</head>

<body>
    <!-- Menu -->
    <x-dashboard-menu/>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <!-- Navbar -->
        <x-dashboard-navbar/>
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                @yield('content')
            </div>
        </div>
        <x-dashboard-footer/>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="../coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script> 
    <script src="../coreui/vendors/simplebar/js/simplebar.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    {{-- <script src="../coreui/vendors/chart.js/js/chart.min.js"></script> --}}
    <script src="../coreui/vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>
    <script src="../coreui/vendors/@coreui/utils/js/coreui-utils.js"></script>
    {{-- <script src="../coreui/js/main.js"></script> --}}
    <livewire:modals/>
    @livewireScripts
    <script src="{{ mix('js/serebo.dashboard.core.js') }}"></script>
    <script src="{{ mix('js/serebo.dashboard.js') }}"></script>
    <script></script>
</body>
</html>
