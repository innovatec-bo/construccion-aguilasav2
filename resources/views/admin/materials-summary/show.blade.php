@extends('adminlte::page')

@section('title', 'Detalle de movimiento')

@section('content_header')
    <h1>Detalle de movimiento</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-primary d-print-none float-right mx-1" href='{{url()->previous()}}'>Volver</a>
                            <a class="btn btn-info d-print-none float-right" href='javascript:void(0)' onclick='window.print();'><i class="fa fa-print fa-fw"></i>Imprimir</a>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <address class="mb-1">
                                <strong>ID</strong><br>
                                {{$materialsSummary->id_msu}}
                            </address>
                            <address class="mb-1">
                                <strong>Fecha</strong><br>
                                {{$materialsSummary->entry_date_msu->format('d-m-Y H:i:s')}}
                            </address>
                            <address class="mb-1">
                                <strong>Nro. Correlativo</strong><br>
                                {{$materialsSummary->correlative_counter_msu}}
                            </address>
                            <address class="mb-1">
                                <strong>Tipo de resumen</strong><br>
                                {{$materialsSummary->summaryType->name_mqt}}
                            </address>
                        </div>
                
                        <div class="col-sm-4 invoice-col">
                            @if ($materialsSummary->fiscal)
                                <address class="mb-1">
                                    <strong>Fiscal</strong><br>
                                    {{$materialsSummary->fiscal->full_name}}
                                </address>    
                            @endif
                            @if ($materialsSummary->builder)
                                <address class="mb-1">
                                    <strong>Constructor</strong><br>
                                    {{$materialsSummary->builder->full_name}}
                                </address>    
                            @endif
                            <address class="mb-1">
                                <strong>Proyecto</strong><br>
                                {{$materialsSummary->project->code_pro}}
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">CODIGO</th>
                                        <th>DESCRIPCION</th>
                                        <th>UNIDAD DE<BR>MEDIDA</th>
                                        <th>CANTIDAD</th>
                                        <th>STATUS</th>
                                        <th>TENSION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materialsSummary->projectMaterials as $projectMaterial)
                                        <tr>
                                            <td>{{ $projectMaterial->material->code_mat }}</td>
                                            <td>{{ $projectMaterial->material->description_mat }}</td>
                                            <td>{{ $projectMaterial->material->unit_of_measurement_mat }}</td>
                                            <td>{{ $projectMaterial->quantity_prm }}</td>
                                            <td>
                                                @if ($projectMaterial->status)
                                                    {{ $projectMaterial->status->detail_mst }}    
                                                @endif
                                                
                                            </td>
                                            <td>
                                                @if ($projectMaterial->tension)
                                                {{ $projectMaterial->tension->detail_mte }}    
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-none d-print-block">
                        <span style="width: 300px;margin-left:25%" class="mt-4">
                            Entregue conforme
                        </span>
                        <span style="width: 300px;margin-left: 100px" class="mt-4">
                            Recibi conforme
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
