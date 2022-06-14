@extends('adminlte::page')

@section('title', 'Conciliacion interna')

@section('content_header')
    <h1>Conciliacion interna: {{$laborDetail->project->code_pro}}</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="alert alert-info alert-dismissible d-print-none">
                <h5><i class="icon fas fa-info"></i> Nota!</h5>
                La presente lista esta basada en la composici&oacute;n estandar de materiales. Para editar la composicion de una estructura acceda al <a class="text-dark" href="{{route('admin.labor-details.show', $laborDetail)}}">detalle de la mano de obra</a> y haga click en el boton de lapiz
            </div>
        </div>
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header d-print-none">
                    <h4 class="card-title">
                        Materiales que deben ser retirados segun el archivo de mano de obra
                    </h4>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="">
                            <a class="btn btn-xs btn-primary d-print-none float-right mx-1" href="{{url()->previous()}}">Volver</a>
                            @can('admin.labor-details.export')
                                {{-- <a href="{{route('admin.labor-details.export', $laborDetail->id_lad)}}" class="btn btn-primary btn-xs d-print-none"><i class="far fa-file-excel"></i> Exportar</a> --}}
                                <a class="btn btn-info btn-xs d-print-none float-right ml-2" href="javascript:void(0)" onclick="window.print();"><i class="fa fa-print fa-fw"></i>Imprimir</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row invoice-info mb-3">
                        <div class="col-md-10 d-none d-print-inline">
                            <h3 class="text-center mb-4">Conciliacion interna</h3>
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
                                    {{-- <th>Presente en las<br>siguientes estructuras</th> --}}
                                    <th>Descripcion</th>
                                    <th>Cantidad a<br>retirar</th>
                                    <th>Cantidad devuelta<br>a almacen</th>
                                    <th>Diferencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materialsToBeReturned as $key => $material)
                                    <tr>
                                        <td>{{($key+1)}}</td>
                                        <td>{{$material['code_mat']}}</td>
                                        <td>{{$material['description_mat']}}</td>
                                        <td class="text-right">                    
                                            {{number_format($material['quantity_csm'],2)}} {{$material['unit_of_measurement_mat']}}
                                        </td>
                                        <td class="text-right" data-structures="{{substr($material['structures'],0,-2)}}">
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
                                            @if (($material['quantity_csm']- $material['quantity_prm']) > 0)
                                                 <i class="fas fa-exclamation text-warning d-print-none"></i>    
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                
                                @foreach ($returnedMaterials as $key => $material)
                                    <tr class="bg-success">
                                        <td>{{($key+1)}}</td>
                                        <td>{{$material['code_mat']}}</td>
                                        <td>{{$material['description_mat']}}</td>
                                        <td class="text-right">                    
                                            {{number_format($material['quantity_csm'],2)}} {{$material['unit_of_measurement_mat']}}
                                        </td>
                                        <td class="text-right">
                                            <p class="badge bg-warning mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                        </td>
                                        <td class="text-right">
                                            {{number_format($material['quantity_csm']- $material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}
                                        </td>
                                    </tr>
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