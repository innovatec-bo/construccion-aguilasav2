@extends('adminlte::page')

@section('title', 'Detalle de la estructura')

@section('content_header')
    <h1>Detalle de la estructura</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card card-widget widget-user-2 shadow-lg">
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username ml-1">{{$buildingStructure->description_bus}}</h3>
                    <h5 class="widget-user-desc ml-1">{{$buildingStructure->structure_code_bus}}</h5>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        @foreach ($buildingStructure->defaultStructureMaterials as $default)
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link text-light">
                                    {{$default->material->code_mat}} -
                                    {{$default->material->description_mat}}
                                    <span class="float-right badge bg-primary">{{$default->quantity_dsm}} {{$default->material->unit_of_measurement_mat}}</span>
                                </a>
                            </li>    
                        @endforeach
                        @if ($buildingStructure->defaultStructureMaterials->count() <= 0)
                            <p class="text-center my-3">No se han establecido materiales para esta estructura</p>
                        @endif
                    </ul>
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
