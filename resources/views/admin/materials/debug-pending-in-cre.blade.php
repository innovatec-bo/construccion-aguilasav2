@extends('layouts.dashboard-layout')

@section('title', 'Depurar materiales pendientes en CRE')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials.debug-pending-in-cre') }}
@stop

@section('content')
    @livewire('admin.material-debug-pending-in-cre')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        select:invalid{
            color: gray;
        }
    </style>
@stop

@section('js')
    @stack('scripts')    
{{-- <script> console.log('Hi!'); </script> --}}
    <script>
        $(function () {
            $('#popover').popover({
                container: 'body',
                html: true,
                title: "Info",
                content: 'Esta opcion permite tener una cantidad absoluta de los totales del proyecto',
                trigger: 'hover',
                template: '<div class="popover dark-mode" role="tooltip"><div class="arrow"></div><h3 class="popover-header dark-mode"></h3><div class="popover-body dark-mode"></div></div>'
            })
        });
    </script>
@stop