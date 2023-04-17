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
    <!-- Vendors styles-->
    {{-- <link rel="stylesheet" href="{{asset('coreui/vendors/simplebar/css/simplebar.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{asset('coreui/css/vendors/simplebar.css')}}"> --}}
    <!-- Main styles for this application-->
    {{-- <link href="{{asset('coreui/css/style.css')}}" rel="stylesheet"> --}}
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css"> --}}
    {{-- <link href="{{asset('coreui/css/examples.css')}}" rel="stylesheet"> --}}
    {{-- <link href="{{asset('coreui/vendors/@coreui/chartjs/css/coreui-chartjs.css')}}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ mix('css/serebo.dashboard.css') }}">
    @livewireStyles
    <style>
        @page {
            size: letter;
        }
        @media print {
        * { background: transparent !important; color: black !important; box-shadow:none !important; text-shadow: none !important; filter:none !important; -ms-filter: none !important; } /* Black prints faster: h5bp.com/s */
            a, a:visited { text-decoration: underline; }
            a[href]:after { content: " (" attr(href) ")"; }
            abbr[title]:after { content: " (" attr(title) ")"; }
            .ir a:after, a[href^="javascript:"]:after, a[href^="#"]:after { content: ""; } /* Don't show links for images, or javascript/internal links */
            pre, blockquote { border: 1px solid #999; page-break-inside: avoid; }
            thead { display: table-header-group; } /* h5bp.com/t */
            tr, img { page-break-inside: avoid; }
            img { max-width: 100% !important; }
            @page { margin: 0.5cm; }
            p, h2, h3 { orphans: 3; widows: 3; }
            h2, h3 { page-break-after: avoid; }
            div.shadow-lg {
                -webkit-box-shadow: none!important;
                -moz-box-shadow:    none!important;
                box-shadow:         none!important; 
            }
        }
    </style> 
    <style>
        .overlay
        {
            border-radius: 0.25rem;
            align-items: center;
            background-color: rgba(255,255,255,.7);
            display: flex;
            justify-content: center;
            z-index: 50;
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }
    </style>
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
    <script src="{{asset('coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script> 
    <script src="{{asset('coreui/vendors/simplebar/js/simplebar.min.js')}}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{asset('coreui/vendors/chart.js/js/chart.min.js')}}"></script>
    <script src="{{asset('coreui/vendors/@coreui/chartjs/js/coreui-chartjs.js')}}"></script>
    <script src="{{asset('coreui/vendors/@coreui/utils/js/coreui-utils.js')}}"></script>
    {{-- <script src="{{('coreui/js/main.js')}}"></script> --}}
    <livewire:modals/>
    @livewireScripts
    <script src="{{ mix('js/serebo.dashboard.core.js') }}"></script>
    <script src="{{asset('bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js')}}"></script>
    {{-- <script src="{{ mix('js/serebo.dashboard.js') }}"></script> --}}
    <script></script>
    @stack('js')
    @yield('js')
</body>
</html>
