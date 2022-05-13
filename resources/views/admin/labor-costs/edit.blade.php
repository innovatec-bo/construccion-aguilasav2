@extends('adminlte::page')

@section('title', 'Editar estructura del proyecto ' . $laborCost->laborDetail->project->code_pro)

@section('content_header')
    <h1>Editar estructura del proyecto {{ $laborCost->laborDetail->project->code_pro }}</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card shadow-lg">
                <div class="card-header bg-info">
                    <h3 class="card-title">Lista completa</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar..">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><span class="text-warning">1234</span> Update software</td>
                                <td style="width: 50px">
                                    <button class="btn btn-sm btn-primary py-0"><i class="fas fa-angle-right"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="text-warning">1234</span> Clean database</td>
                                <td><button class="btn btn-sm btn-primary py-0"><i class="fas fa-angle-right"></i></button></td>
                            </tr>
                            <tr>
                                <td><span class="text-warning">1234</span> Cron job running</td>
                                <td><button class="btn btn-sm btn-primary py-0"><i class="fas fa-angle-right"></i></button></td>
                            </tr>
                            <tr>
                                <td><span class="text-warning">1234</span> Fix and squish bugs</td>
                                <td><button class="btn btn-sm btn-primary py-0"><i class="fas fa-angle-right"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </div>
            </div>



        </div>
        <div class="col-md-6">
            <div class="card card-widget widget-user-2 shadow-lg">
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username ml-1">{{ $laborCost->buildingStructure->description_bus }}</h3>
                    <h5 class="widget-user-desc ml-1">{{ $laborCost->buildingStructure->structure_code_bus }}</h5>
                    <button type="button" class="btn btn-success float-right">Guardar</button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th style="width: 10px">Codigo</th>
                                <th>Material</th>
                                <th style="width: 120px">Cantidad</th>
                                <th style="width: 90px">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laborCost->customStructureMaterials as $custom)
                                <tr>
                                    <td class="text-warning">{{ $custom->material->code_mat }}</td>
                                    <td>{{ $custom->material->description_mat }}</td>
                                    <td class="">
                                        <input type="text" class="input-mask text-right" name=""
                                            value="{{ $custom->quantity_csm }}" id="" style="width: 80px">
                                        {{ $custom->material->unit_of_measurement_mat }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-danger py-0"><i
                                                class="fas fa-fw fa-times"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
