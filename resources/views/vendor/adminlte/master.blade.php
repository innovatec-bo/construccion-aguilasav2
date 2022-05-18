<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>
    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif
    
    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif
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
    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')
    
    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif
    <style>
        .overlay
        {
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }
    </style>
</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

        {{-- Configured Scripts --}}
        @include('adminlte::plugins', ['type' => 'js'])

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

{{-- Toast notifications --}}
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
                // "positionClass": "toast-top-center",
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
<script>
    $(function () {
      bsCustomFileInput.init();
      $('[data-toggle=tooltip]').tooltip();
    });
    </script>
    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>
