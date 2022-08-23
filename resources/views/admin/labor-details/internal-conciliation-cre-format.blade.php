@extends('adminlte::page')

@section('title', 'Conciliacion interna(Formato CRE): '.$laborDetail->project->code_pro)

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Conciliacion interna en {!! ($laborDetail->environment['label']) !!}(Formato CRE): {{$laborDetail->project->code_pro}}</h1>
        </div>
        <div class="col-sm-6">
            {{ Breadcrumbs::render('admin.labor-details.internal-conciliation-cre-format', $laborDetail) }}
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header d-print-none">
                    <h4 class="card-title">
                        Materiales que deben ser retirados segun el archivo de mano de obra
                    </h4>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="">
                            <a class="btn btn-xs btn-primary d-print-none float-right mx-1" href="{{url()->previous()}}">Volver</a>
                            @can('admin.labor-details.export-internal-conciliation-cre-format')
                                <a href="{{route('admin.labor-details.export-internal-conciliation-cre-format', $laborDetail->id_lad)}}" class="btn btn-primary btn-xs d-print-none"><i class="far fa-file-excel"></i> Exportar</a>
                                <a class="btn btn-info btn-xs d-print-none float-right ml-2" href="javascript:void(0)" onclick="window.print();"><i class="fa fa-print fa-fw"></i>Imprimir</a>
                            @endcan
                        </div>
                    </div>
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
                                    <td class="text-right">                    
                                        {{number_format($row['materials_picked_up_from_cre'],2)}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($row['total_used'],2)}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($row['return_to_serebo'],2)}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($row['return_to_cre'],2)}}
                                    </td>
                                    <td class="text-right">
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
@stop
