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
    <link rel="stylesheet" href="{{ mix('css/serebo.dashboard.css') }}">
    @stack('css')
    @yield('css')
    @stack('styles')
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
    <livewire:modals/>
    @livewireScripts
    <script src="{{ mix('js/serebo.dashboard.core.js') }}"></script>
    <script src="{{ mix('js/serebo.dashboard.js') }}"></script>
    <script></script>
    <script>
        function decodeHtml(html)
            {
                var txt = document.createElement("textarea");
                txt.innerHTML = html;
                return txt.value;
            }
            window.toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true,
                    "positionClass": "toast-top-right mt-1",
                    "timeOut": "10000",
                    "allowHtml": true,
                    "preventDuplicates": true
                }
            @if(session('successMessage'))
                window.toastr.success("{{session('successMessage')}}");
            @endif
            @if(session('errorMessage'))
                window.toastr.error("{{session('errorMessage')}}");
            @endif
            @if(session('infoMessage'))
                window.toastr.info("{{session('infoMessage')}}");
            @endif
            @if(session('warningMessage'))
                window.toastr.warning( decodeHtml("{{session('warningMessage')}}") );
            @endif
            //Trigger from livewire
            document.addEventListener('DOMContentLoaded', function(){
                window.addEventListener('alert', event => {
                    let type = event.detail[0];
                    let message = event.detail[1];
                    switch (event.detail[0]) {
                        case 'successMessage':
                                window.toastr.success(message);
                            break;
                        case 'errorMessage':
                                window.toastr.error(message);
                            break;
                        case 'infoMessage':
                                window.toastr.info(message);
                            break;
                        case 'warningMessage':
                            window.toastr.warning(message);
                            break;
                    }
                });
            });
            </script>
    @stack('js')
    @yield('js')
    @stack('scripts')
</body>
</html>
