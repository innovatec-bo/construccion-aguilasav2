@extends('adminlte::page')

@section('title', 'Resumen de materiales')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Resumen de materiales</h1>
        </div>
        {{-- <div class="col-sm-6">
            {{ Breadcrumbs::render('admin.materials-summary.index') }}
        </div> --}}
    </div>
@stop

@section('content')
    @livewire('admin.material-summary')
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