@extends('adminlte::page')

@section('title', 'Editar estructura del proyecto ' . $laborCost->laborDetail->project->code_pro)

@section('content_header')
    <h1>Editar estructura del proyecto {{ $laborCost->laborDetail->project->code_pro }}</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-widget widget-user-2 shadow-lg">
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username ml-1">{{ $laborCost->buildingStructure->description_bus }}</h3>
                    <h5 class="widget-user-desc ml-1">{{ $laborCost->buildingStructure->structure_code_bus }}</h5>
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
                                    <input type="text" class="input-mask text-right" name="" value="{{$custom->quantity_csm}}" id="" style="width: 80px"> {{ $custom->material->unit_of_measurement_mat }}
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-danger py-0"><i class="fas fa-fw fa-times"></i></a>
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
