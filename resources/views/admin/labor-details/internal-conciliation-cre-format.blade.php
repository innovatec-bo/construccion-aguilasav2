@extends('layouts.dashboard-layout')

@section('title', 'Conciliacion interna(Formato CRE): '.$laborDetail->project->code_pro)

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.labor-details.internal-conciliation-cre-format', $laborDetail) }}
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-2 text-end">
            <a class="btn btn-sm btn-primary d-print-none float-right mx-1" href="{{url()->previous()}}">Volver</a>
            @can('admin.labor-details.export-internal-conciliation-cre-format')
                <div class="btn-group btn-group-sm" style="">
                    <a href="{{route('admin.labor-details.export-internal-conciliation-cre-format', $laborDetail->id_lad)}}" class="btn btn-primary d-print-none"><i class="far fa-file-excel"></i> Exportar</a>
                    <a class="btn btn-info d-print-none float-right ml-2 text-white" href="javascript:void(0)" id="btn-print"><i class="fa fa-print fa-fw"></i>Imprimir</a>
                </div>
            @endcan
        </div>
        <div class="col-md-12">
            <div class="card shadow-lg" id="print-area">
                <div class="card-header d-print-none">
                    <h4 class="card-title">
                        Materiales que deben ser retirados segun el archivo de mano de obra
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row invoice-info mb-3">
                        <div class="col-md-10 d-none d-print-inline">
                            <h3 class="text-center mb-0">Conciliacion interna(Formato CRE)</h3>
                            <h4 class="text-center mb-4">{!! ($laborDetail->environment['label']) !!}</h4>
                        </div>
                        <div class="col-sm-2 invoice-col">
                            <address class="mb-1">
                                <strong>Fiscal</strong><br>
                                @foreach ($laborDetail->project->statusLogResponsibles as $statusLogResponsible)
                                    @if ($statusLogResponsible->responsible->user->hasRole('Fiscal'))
                                        {{$statusLogResponsible->responsible->user->full_name}}
                                    @endif
                                @endforeach
                            </address>    
                        </div>
                        <div class="col-sm-2 invoice-col">
                            <address class="mb-1">
                                <strong>Constructor</strong><br>
                                @foreach ($laborDetail->project->statusLogResponsibles as $statusLogResponsible)
                                    @if ($statusLogResponsible->responsible->user->hasRole('Builder'))
                                        {{$statusLogResponsible->responsible->user->full_name}}
                                    @endif
                                @endforeach
                            </address>
                        </div>
                        <div class="col-sm-2 invoice-col">
                            <address class="mb-1">
                                <strong>Proyecto</strong><br>
                                {{$laborDetail->project->code_pro}}
                            </address>
                        </div>
                    </div>
                    <table class="table table-bordered table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>C&oacute;digo</th>
                                <th>Descripci&oacute;n</th>
                                <th>Retirado<br>de CRE</th>
                                <th>Entregado menos<br>devuelto(NVO)</th>
                                <th>Devuelve<br>CRE(NVO)</th>
                                <th>Devuelve<br>SEREBO(NVO)</th>
                                <th>Devuelve<br>SEREBO(MEO)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i =1;
                            @endphp
                            @foreach ($laborDetail->internalConciliationCreFormat() as $key => $row)
                                <tr>
                                    <td>{{($i)}}</td>
                                    <td>{{$row['material_code']}}</td>
                                    <td>{{$row['material_description']}}</td>
                                    <td class="text-end">                    
                                        {{number_format($row['materials_picked_up_from_cre'],2)}}
                                    </td>
                                    <td class="text-end">
                                        {{number_format($row['total_used'],2)}}
                                    </td>
                                    <td class="text-end">
                                        {{number_format($row['return_to_serebo'],2)}}
                                    </td>
                                    <td class="text-end">
                                        {{number_format($row['return_to_cre'],2)}}
                                    </td>
                                    <td class="text-end">
                                        {{number_format($row['builder_returns_materials_meo'],2)}}
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- @livewire('admin.labor-detail-index') --}}
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    <script src="{{asset('js/jQuery.print/jQuery.print.js')}}"></script>
    <script>
        $('#btn-print').on('click', function() {
            $.print($("#print-area").html());
            // let CSRF_TOKEN = $('meta[name="csrf-token"').attr('content');
            // let body = $("#print-area").html();
            // $.ajax({
            //     url: '{{route('admin.print')}}',
            //     type: 'POST',
            //     data: {
            //         _token: CSRF_TOKEN,
            //         body: body
            //     },
            //     beforeSend: function() {
            //         console.log('printing ...');
            //     },
            //     complete: function() {
            //         console.log('printed!');
            //     },
            //     success: function(viewContent) {
            //         $.print(viewContent);
            //     }
            // });
        });
    </script>
@stop
