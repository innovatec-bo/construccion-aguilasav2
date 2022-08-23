@extends('adminlte::page')

@section('title', 'Conciliacion internal(Vista de constructor): '.$laborDetail->project->code_pro)

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Conciliacion internal en {!!$laborDetail->environment['label']!!}(Vista de constructor): {{$laborDetail->project->code_pro}}</h1>
        </div>
        <div class="col-sm-6">
            {{ Breadcrumbs::render('admin.labor-details.internal-conciliation-builder', $laborDetail, $previousRoute) }}
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
                            @can('admin.labor-details.internal-conciliation-builder')
                                {{-- <a href="{{route('admin.labor-details.internal-conciliation-builder', $laborDetail->id_lad)}}" class="btn btn-primary btn-xs d-print-none"><i class="far fa-file-excel"></i> Exportar</a> --}}
                                <a class="btn btn-info btn-xs d-print-none float-right ml-2" href="javascript:void(0)" onclick="window.print();"><i class="fa fa-print fa-fw"></i>Imprimir</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row invoice-info mb-3">
                        <div class="col-md-10 d-none d-print-inline">
                            <h3 class="text-center mb-0">Conciliacion interna(Vista de constructor)</h3>
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
                    @if (count($materialsToBeReturned) > 0)
                        <table class="table table-bordered table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>C&oacute;digo</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad a<br>retirar</th>
                                    <th>Cantidad devuelta<br>a almacen</th>
                                    <th>Diferencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i =1;
                                @endphp
                                @foreach ($materialsToBeReturned as $key => $material)
                                    @if ($material['quantity_prm'] == 0 || $material['quantity_prm'] < $material['quantity_csm'])
                                        <tr>
                                            <td>{{($i)}}</td>
                                            <td>{{$material['code_mat']}}</td>
                                            <td>{{$material['description_mat']}}</td>
                                            <td class="text-right">                    
                                                {{number_format($material['quantity_csm'],2)}} {{$material['unit_of_measurement_mat']}}
                                            </td>
                                            <td class="text-right">
                                                @if ($material['quantity_csm'] == $material['quantity_prm'])
                                                    <p class="badge bg-success d-print-none mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                                @elseif($material['quantity_prm'] > 0 && $material['quantity_csm'] > $material['quantity_prm'])
                                                    <p class="badge bg-info d-print-none mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                                @elseif($material['quantity_prm'] == 0)
                                                    <p class="badge bg-danger d-print-none mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                                @elseif($material['quantity_prm'] > $material['quantity_csm'])
                                                    <p class="badge bg-warning d-print-none mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                                @endif
                                                <p class="d-none d-print-inline mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            </td>
                                            <td class="text-right">
                                                {{number_format($material['quantity_csm']- $material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp    
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else 
                        La mano de obra no presenta actividad de retiro
                    @endif
                    
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
