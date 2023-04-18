@extends('layouts.dashboard-layout')

@section('title', 'Salidas duplicadas')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials-summary.duplicate-outputs') }}
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered small table-sm table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Codigo de<br>Proyecto</th>
                            <th>ID<br>Movimiento</th>
                            <th>Fecha de<br>movimiento</th>
                            <th>Movimiento</th>
                            <th>Descripcion de<br>Material</th>
                            <th>Cantidad <br>Movida</th>
                            <th>Balance</th>
                            <th>Historia de movimientos</th>
                            <th>Patron de movimientos</th>
                            <th>Movimientos uniformes</th>
                            <th>Movimientos</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;  
                        @endphp
                        @foreach ($materialsSummary as $key => $item)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->code_pro}}</td>
                                <td class="text-end">{{$item->id_msu}}</td>
                                <td class="text-end">{{$item->entry_date_msu}}</td>
                                <td>
                                    @if ($item->movement_type_mqt == 'out')
                                        <span class="text-info fw-bold">Salida: </span>
                                    @else
                                        <span class="text-success fw-bold">Entrada: </span>        
                                    @endif
                                    
                                    {{$item->name_mqt}}
                                </td>
                                <td class="text-left"><span class="text-info">{{$item->code_mat}}:</span> {{$item->description_mat}}</td>
                                <td class="text-end">{{$item->quantity_prm}}</td>
                                <td class="text-end">{{$item->balance}}</td>
                                <td class="text-end">{{$item->balance_string}}</td>
                                <td class="text-center fs-2">{{$item->pattern}}</td>
                                <td class="text-center">{{$item->uniform_movement}}</td>
                                <td class="text-end">{{$item->movements}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" id="dropdownMenuButton" type="button" data-coreui-toggle="dropdown" aria-expanded="false"><i class="fas fa-cogs"></i></button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                                            <li>
                                                @can('admin.materials-summary.grouped-movement-details')
                                                    <a wire:loading.class="disabled" target="_blank" class="dropdown-item" href='{{route('admin.materials-summary.grouped-movement-details', ['project' => $item->id_pro,'search' => $item->code_mat])}}'"><i class="fas fa-eye"></i> Detalle de movimiento</a>
                                                @endcan
                                            </li>
                                            <li>
                                                @can('admin.materials-summary.duplicate-outputs')
                                                    <form action="{{route('admin.project-materials.destroy', $item->id_prm)}}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button wire:loading.class="disabled" type="submit" onclick="return confirm('Eliminar salida de material? Solo se eliminara el material {{$item->code_mat}} presente en la lista {{$item->id_msu}}')" class="dropdown-item"><i class="fas fa-times"></i> Eliminar registro de salida</button>
                                                    </form>
                                                @endcan
                                            </li>
                                        </ul>
                                    </div>
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
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
